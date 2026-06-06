<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;

class Siswa extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
        $this->load->model('M_akademik');
        $this->load->model('M_user');
    }

    public function index() {
        $data = [
            'title'     => 'Manajemen Data Siswa',
            'content'   => 'admin/siswa_list',
            'siswa'     => $this->M_akademik->get_all_siswa(),
            'kelas'     => $this->M_akademik->get_all_kelas(),
            'orang_tua' => $this->M_user->get_all_orangtua()
        ];
        $this->load->view('layouts/master', $data);
    }

    public function tambah() {
        $nis = $this->input->post('nis', TRUE);
        $encrypted_token = md5($nis . time());

        $path_folder = FCPATH . 'uploads/qrcode/';
        if (!is_dir($path_folder)) {
            mkdir($path_folder, 0777, true);
        }
        
        $savename = $path_folder . $nis . '.png';

        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($encrypted_token)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();

        $result->saveToFile($savename);

        $data_siswa = [
            'nis'          => $nis,
            'nama'         => $this->input->post('nama', TRUE),
            'kelas'        => $this->input->post('kelas', TRUE),
            'qr_code'      => $encrypted_token,
            'id_orangtua'  => $this->input->post('id_orangtua', TRUE)
        ];

        $this->M_akademik->insert_siswa($data_siswa);
        $this->session->set_flashdata('success', 'Data siswa dan QR Code berhasil dibuat.');
        redirect('admin/siswa');
    }

    public function ubah($id_siswa)
    {
        // Jalankan rules pengkondisian form validation
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/siswa');
        } else {
            $data_update = [
                'nama'          => $this->input->post('nama', TRUE),
                'kelas'         => $this->input->post('kelas', TRUE),
                'id_orangtua'   => !empty($this->input->post('id_orangtua')) ? $this->input->post('id_orangtua', TRUE) : NULL
            ];

            // Eksekusi update data ke tabel siswa Anda
            $this->db->where('id_siswa', $id_siswa);
            $this->db->update('siswa', $data_update);

            $this->session->set_flashdata('success', 'Data informasi siswa berhasil diperbarui.');
            redirect('admin/siswa');
        }
    }

    public function generate_ulang_qr() {
        $siswa = $this->M_akademik->get_all_siswa();
        $path_folder = FCPATH . 'uploads/qrcode/';
        
        if (!is_dir($path_folder)) {
            mkdir($path_folder, 0777, true);
        }

        $berhasil = 0;

        foreach ($siswa as $s) {
            $savename = $path_folder . $s['nis'] . '.png';
            
            if (!file_exists($savename)) {
                $result = Builder::create()
                    ->writer(new PngWriter())
                    ->data($s['qr_code'])
                    ->encoding(new Encoding('UTF-8'))
                    ->errorCorrectionLevel(ErrorCorrectionLevel::High)
                    ->size(300)
                    ->margin(10)
                    ->build();

                $result->saveToFile($savename);
                $berhasil++;
            }
        }

        $this->session->set_flashdata('success', $berhasil . ' QR Code berhasil digenerate ulang.');
        redirect('admin/siswa');
    }
}