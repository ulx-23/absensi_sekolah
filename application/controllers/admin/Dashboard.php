<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Cek apakah user sudah login dan rolenya adalah admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index() {
        $tanggal_hari_ini = date('Y-m-d');

        // 1. Hitung data statistik riil hari ini dari tabel absensi
        $data['total_hadir']     = $this->db->get_where('absensi', ['tanggal' => $tanggal_hari_ini, 'status' => 'hadir'])->num_rows();
        $data['total_terlambat'] = $this->db->get_where('absensi', ['tanggal' => $tanggal_hari_ini, 'status' => 'terlambat'])->num_rows();
        
        // 2. Hitung total siswa dan siswa yang belum absen (alfa)
        $total_siswa             = $this->db->get('siswa')->num_rows();
        $data['total_alfa']      = $total_siswa - ($data['total_hadir'] + $data['total_terlambat']);
        
        // SINKRONISASI TABEL KELAS: Diubah ke 'm_kelas' sesuai rancangan awal modul akademik
        $data['total_kelas']     = $this->db->get('m_kelas')->num_rows(); 

        // 3. Ambil data statistik 7 hari terakhir untuk grafik batang/garis
        // Menggunakan COUNT(id_siswa) sebagai indikator agregat penghitung ketukan kartu
        $this->db->select('tanggal, COUNT(id_siswa) as total');
        $this->db->from('absensi');
        $this->db->where('tanggal <=', $tanggal_hari_ini);
        $this->db->group_by('tanggal');
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(7);
        $tren_absensi = array_reverse($this->db->get()->result_array());

        // Konversi data database ke format Array PHP agar bisa dibaca oleh JavaScript Chart
        $label_grafik = [];
        $data_grafik  = [];
        foreach ($tren_absensi as $row) {
            $label_grafik[] = date('d M', strtotime($row['tanggal']));
            $data_grafik[]  = $row['total'];
        }

        // Kirim data grafik ke view dalam format JSON
        $data['label_grafik'] = json_encode($label_grafik);
        $data['data_grafik']  = json_encode($data_grafik);

        // Load view utama admin
        $data['title']   = 'Dashboard Admin';
        $data['content'] = 'admin/dashboard'; 
        $this->load->view('layouts/master', $data);
    }
}