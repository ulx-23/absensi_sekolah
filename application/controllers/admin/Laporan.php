<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
        $this->load->model('M_laporan');
        $this->load->model('M_akademik');
    }

    public function index()
    {
        // Tangkap parameter filter dari GET form
        $tgl_mulai   = $this->input->get('tgl_mulai', TRUE);
        $tgl_selesai = $this->input->get('tgl_selesai', TRUE);
        $kelas       = $this->input->get('kelas', TRUE);

        $data = [
            'title'       => 'Laporan Absensi Siswa',
            'content'     => 'admin/laporan_view',
            'kelas_list'  => $this->M_akademik->get_all_kelas(),
            'absensi'     => $this->M_laporan->get_filter_absensi($tgl_mulai, $tgl_selesai, $kelas),
            'tgl_mulai'   => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'kelas_pilih' => $kelas
        ];

        $this->load->view('layouts/master', $data);
    }

    public function cetak()
    {
        $tgl_mulai   = $this->input->get('tgl_mulai', TRUE);
        $tgl_selesai = $this->input->get('tgl_selesai', TRUE);
        $kelas       = $this->input->get('kelas', TRUE);

        $data = [
            'absensi'     => $this->M_laporan->get_filter_absensi($tgl_mulai, $tgl_selesai, $kelas),
            'tgl_mulai'   => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'kelas_pilih' => $kelas
        ];

        // Memuat view cetak khusus tanpa komponen sidebar/navbar master
        $this->load->view('admin/laporan_print', $data);
    }
}