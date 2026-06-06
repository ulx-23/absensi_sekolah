<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jam_masuk extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Proteksi hak akses Admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index()
    {
        // Ambil data konfigurasi jam masuk dari database
        $jam_masuk = $this->db->get_where('pengaturan', ['nama_pengaturan' => 'jam_masuk'])->row_array();

        $data = [
            'title'     => 'Konfigurasi Jam Masuk',
            'content'   => 'admin/jam_masuk_view',
            'jam_masuk' => $jam_masuk ? $jam_masuk['nilai'] : '07:15:00'
        ];

        $this->load->view('layouts/master', $data);
    }

    public function update()
    {
        $this->form_validation->set_rules('jam_masuk', 'Jam Masuk', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $jam_baru = $this->input->post('jam_masuk', TRUE);

            // Tambahkan format detik jika inputan hanya HH:MM
            if (strlen($jam_baru) == 5) {
                $jam_baru .= ':00';
            }

            // Update nilai di tabel pengaturan
            $this->db->where('nama_pengaturan', 'jam_masuk');
            $this->db->update('pengaturan', ['nilai' => $jam_baru]);

            $this->session->set_flashdata('success', 'Jam masuk sekolah berhasil diperbarui menjadi ' . date('H:i', strtotime($jam_baru)) . ' WIB.');
            redirect('admin/jam_masuk');
        }
    }
}