<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akademik extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
        $this->load->model('M_akademik');
    }

    // --- FITUR KELAS ---
    public function kelas() {
        $data = [
            'title'   => 'Kelola Kelas',
            'content' => 'admin/kelas_list',
            'kelas'   => $this->M_akademik->get_all_kelas()
        ];
        $this->load->view('layouts/master', $data);
    }

    public function kelas_tambah() {
        $data = ['nama_kelas' => $this->input->post('nama_kelas', TRUE)];
        $this->M_akademik->insert_kelas($data);
        $this->session->set_flashdata('success', 'Kelas baru berhasil ditambahkan.');
        redirect('admin/akademik/kelas');
    }

    public function kelas_ubah($id) {
        $data = ['nama_kelas' => $this->input->post('nama_kelas', TRUE)];
        $this->M_akademik->update_kelas($id, $data);
        $this->session->set_flashdata('success', 'Data kelas berhasil diubah.');
        redirect('admin/akademik/kelas');
    }

    public function kelas_hapus($id) {
        $this->M_akademik->delete_kelas($id);
        $this->session->set_flashdata('success', 'Kelas berhasil dihapus.');
        redirect('admin/akademik/kelas');
    }

    // --- FITUR TAHUN AJARAN ---
    public function tahun_ajaran() {
        $data = [
            'title'   => 'Kelola Tahun Ajaran',
            'content' => 'admin/tahun_list',
            'tahun'   => $this->M_akademik->get_all_tahun()
        ];
        $this->load->view('layouts/master', $data);
    }

    public function tahun_tambah() {
        $data = [
            'tahun_ajaran' => $this->input->post('tahun_ajaran', TRUE),
            'status'       => 'tidak_aktif'
        ];
        $this->M_akademik->insert_tahun($data);
        $this->session->set_flashdata('success', 'Tahun ajaran baru berhasil ditambahkan.');
        redirect('admin/akademik/tahun_ajaran');
    }

    public function tahun_aktifkan($id) {
        $this->M_akademik->set_aktif_tahun($id);
        $this->session->set_flashdata('success', 'Tahun ajaran aktif berhasil diperbarui.');
        redirect('admin/akademik/tahun_ajaran');
    }

    public function tahun_hapus($id) {
        $this->M_akademik->delete_tahun($id);
        $this->session->set_flashdata('success', 'Tahun ajaran berhasil dihapus.');
        redirect('admin/akademik/tahun_ajaran');
    }
}