<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Pastikan yang mengakses adalah petugas gerbang
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'petugas') {
            redirect('auth');
        }
        $this->load->model('M_auth'); // Untuk mengambil data profil/pengaturan jika diperlukan
    }

    public function index() {
        $data = [
            'title'   => 'Scan Absensi Siswa',
            'content' => 'petugas/scanner'
        ];
        $this->load->view('layouts/master', $data);
    }

    public function proses_scan() {
        // Ambil token QR Code dari POST AJAX
        $qr_token = $this->input->post('qr_code', TRUE);
        $id_petugas = $this->session->userdata('id_user');
        $tanggal_hari_ini = date('Y-m-d');
        $jam_sekarang = date('H:i:s');

        if (empty($qr_token)) {
            echo json_encode(['status' => 'error', 'message' => 'Token tidak valid']);
            return;
        }

        // 1. Cari data siswa sekaligus JOIN ke tabel orang tua (Ambil Nomor HP & Email)
        $this->db->select('siswa.*, orang_tua.hp as hp_ortu, orang_tua.email as email_ortu');
        $this->db->from('siswa');
        $this->db->join('orang_tua', 'siswa.id_orangtua = orang_tua.id_orangtua', 'left');
        $this->db->where('siswa.qr_code', $qr_token);
        $siswa = $this->db->get()->row_array();

        if (!$siswa) {
            echo json_encode(['status' => 'error', 'message' => 'QR Code Tidak Dikenali!']);
            return;
        }

        // 2. Validasi Anti Double Scan (Cek apakah sudah scan hari ini)
        $this->db->where('id_siswa', $siswa['id_siswa']);
        $this->db->where('tanggal', $tanggal_hari_ini);
        $cek_absensi = $this->db->get('absensi')->row_array();

        if ($cek_absensi) {
            echo json_encode([
                'status'  => 'warning',
                'message' => 'Sudah melakukan absensi hari ini!',
                'nama'    => $siswa['nama'],
                'kelas'   => $siswa['kelas']
            ]);
            return;
        }

        // 3. Validasi Keterlambatan berdasarkan tabel pengaturan
        $pengaturan = $this->db->get_where('pengaturan', ['nama_pengaturan' => 'jam_masuk'])->row_array();
        $jam_masuk_limit = $pengaturan ? $pengaturan['nilai'] : '07:15:00';

        // Tentukan status hadir / terlambat
        $status_absen = (strtotime($jam_sekarang) <= strtotime($jam_masuk_limit)) ? 'hadir' : 'terlambat';

        // 4. Simpan ke Database
        $data_absensi = [
            'id_siswa'   => $siswa['id_siswa'],
            'tanggal'    => $tanggal_hari_ini,
            'jam_masuk'  => $jam_sekarang,
            'status'     => $status_absen,
            'id_petugas' => $id_petugas
        ];
        
        $this->db->insert('absensi', $data_absensi);

        // ========================================================
        // ENGINE 1: INTEGRASI OTOMATIS WHATSAPP API GATEWAY
        // ========================================================
        $cek_wa = $this->db->get_where('pengaturan', ['nama_pengaturan' => 'notif_whatsapp'])->row_array();
        
        if ($cek_wa && $cek_wa['nilai'] == 'aktif' && !empty($siswa['hp_ortu'])) {
            
            $template_raw = $this->db->get_where('pengaturan', ['nama_pengaturan' => 'template_notif'])->row_array()['nilai'];

            $pesan_final = str_replace(
                ['{nama}', '{nis}', '{kelas}', '{tanggal}', '{jam}', '{status}'],
                [
                    $siswa['nama'], 
                    $siswa['nis'], 
                    $siswa['kelas'], 
                    date('d-m-Y', strtotime($tanggal_hari_ini)), 
                    date('H:i', strtotime($jam_sekarang)), 
                    ucfirst($status_absen)
                ],
                $template_raw
            );

            $target_no_hp = $siswa['hp_ortu']; 
            $api_token    = "eAfArYeVeobncwna5kJZ";

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                 Eustace => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target'      => $target_no_hp,
                    'message'     => $pesan_final,
                    'countryCode' => '62',
                ),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: " . $api_token
                ),
            ));

            $response_api = curl_exec($curl);
            curl_close($curl);
        }

        // ========================================================
        // ENGINE 2: INTEGRASI OTOMATIS EMAIL SMTP (SIMPLE MAIL)
        // ========================================================
        $cek_email = $this->db->get_where('pengaturan', ['nama_pengaturan' => 'notif_email'])->row_array();
        
        if ($cek_email && $cek_email['nilai'] == 'aktif' && !empty($siswa['email_ortu'])) {
            
            $template_raw = $this->db->get_where('pengaturan', ['nama_pengaturan' => 'template_notif'])->row_array()['nilai'];

            $pesan_email = str_replace(
                ['{nama}', '{nis}', '{kelas}', '{tanggal}', '{jam}', '{status}'],
                [
                    $siswa['nama'], 
                    $siswa['nis'], 
                    $siswa['kelas'], 
                    date('d-m-Y', strtotime($tanggal_hari_ini)), 
                    date('H:i', strtotime($jam_sekarang)), 
                    ucfirst($status_absen)
                ],
                $template_raw
            );

            $this->load->library('email');

            // SINKRONISASI PENGATURAN SERVER SMTP
          $config_smtp = array(
                'protocol'     => 'smtp',
                'smtp_host'    => 'ssl://smtp.gmail.com',
                'smtp_port'    => 465,
                'smtp_user'    => 'ululazmiul0@gmail.com', // 🟢 Sudah disesuaikan dengan email Anda
                'smtp_pass'    => '',      // 🟢 Sudah disesuaikan dengan sandi aplikasi Anda (tanpa spasi)
                'mailtype'     => 'html',
                'charset'      => 'utf-8',
                'newline'      => "\r\n",
                'smtp_timeout' => 30
            );

            $this->email->initialize($config_smtp);

            $this->email->from('email_sekolah_anda@gmail.com', 'Sistem Absensi Kehadiran Sekolah');
            $this->email->to($siswa['email_ortu']);
            $this->email->subject('Notifikasi Kehadiran Siswa: ' . $siswa['nama']);
            $this->email->message($pesan_email);

            // Menggunakan penanda @ agar scanner tetap lancar jika jaringan melambat
            @$this->email->send();
            $this->email->clear();
        }

        // Send response sukses balik ke AJAX browser
        echo json_encode([
            'status'    => 'success',
            'message'   => 'Absensi Berhasil!',
            'nama'      => $siswa['nama'],
            'kelas'     => $siswa['kelas'],
            'jam'       => date('H:i', strtotime($jam_sekarang)) . ' WIB',
            'kondisi'   => ucfirst($status_absen)
        ]);
    }
}
