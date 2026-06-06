<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Proteksi hak akses, pastikan hanya petugas yang bisa masuk
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'petugas') {
            redirect('auth');
        }
        $this->load->model('M_laporan');
    }

    public function index()
    {
        $data = [
            'title'   => 'Riwayat Absensi Hari Ini',
            'content' => 'petugas/riwayat_view',
            'absensi' => $this->M_laporan->get_absensi_hari_ini()
        ];

        $this->load->view('layouts/master', $data);
    }
}