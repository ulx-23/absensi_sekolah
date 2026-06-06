<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index()
    {
        // Mengambil semua baris konfigurasi dari tabel pengaturan
        $config_data = $this->db->get('pengaturan')->result_array();
        
        // Memetakan array database agar mudah dibaca di View
        $pengaturan = [];
        foreach ($config_data as $row) {
            $pengaturan[$row['nama_pengaturan']] = $row['nilai'];
        }

        $data = [
            'title'      => 'Pengaturan Notifikasi',
            'content'    => 'admin/notifikasi_view',
            'config'     => $pengaturan
        ];

        $this->load->view('layouts/master', $data);
    }

    public function update()
    {
        // Ambil data dari post form
        $whatsapp = $this->input->post('notif_whatsapp') ? 'aktif' : 'tidak_aktif';
        $telegram = $this->input->post('notif_telegram') ? 'aktif' : 'tidak_aktif';
        $email    = $this->input->post('notif_email') ? 'aktif' : 'tidak_aktif';
        $template = $this->input->post('template_notif', TRUE);

        // Update masing-masing pengaturan ke database
        $this->db->update('pengaturan', ['nilai' => $whatsapp], ['nama_pengaturan' => 'notif_whatsapp']);
        $this->db->update('pengaturan', ['nilai' => $telegram], ['nama_pengaturan' => 'notif_telegram']);
        $this->db->update('pengaturan', ['nilai' => $email],    ['nama_pengaturan' => 'notif_email']);
        $this->db->update('pengaturan', ['nilai' => $template], ['nama_pengaturan' => 'template_notif']);

        $this->session->set_flashdata('success', 'Konfigurasi media dan template notifikasi berhasil diperbarui.');
        redirect('admin/notifikasi');
    }
}