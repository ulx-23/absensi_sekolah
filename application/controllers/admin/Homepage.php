<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
        $this->load->library('form_validation');
    }

    public function index()
    {
        $config_data = $this->db->get('pengaturan')->result_array();
        $pengaturan = [];
        foreach ($config_data as $row) {
            $pengaturan[$row['nama_pengaturan']] = $row['nilai'];
        }

        $data = [
            'title'   => 'Pengaturan Halaman Beranda',
            'content' => 'admin/homepage_settings',
            'config'  => $pengaturan
        ];

        $this->load->view('layouts/master', $data);
    }

    public function update()
    {
        $this->form_validation->set_rules('home_about_title', 'Judul Bagian Tentang', 'required|trim');
        $this->form_validation->set_rules('home_about_subtitle', 'Subjudul Bagian Tentang', 'required|trim');
        $this->form_validation->set_rules('home_about_description', 'Deskripsi Bagian Tentang', 'required|trim');
        $this->form_validation->set_rules('home_contact_title', 'Judul Bagian Kontak', 'required|trim');
        $this->form_validation->set_rules('home_contact_subtitle', 'Subjudul Bagian Kontak', 'required|trim');
        $this->form_validation->set_rules('home_contact_phone', 'Nomor Telepon Kontak', 'required|trim');
        $this->form_validation->set_rules('home_contact_email', 'Email Kontak', 'required|trim|valid_email');
        $this->form_validation->set_rules('home_contact_address', 'Alamat Kontak', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/homepage');
            return;
        }

        $this->save_pengaturan('home_about_title', $this->input->post('home_about_title', TRUE));
        $this->save_pengaturan('home_about_subtitle', $this->input->post('home_about_subtitle', TRUE));
        $this->save_pengaturan('home_about_description', $this->input->post('home_about_description', TRUE));
        $this->save_pengaturan('home_contact_title', $this->input->post('home_contact_title', TRUE));
        $this->save_pengaturan('home_contact_subtitle', $this->input->post('home_contact_subtitle', TRUE));
        $this->save_pengaturan('home_contact_phone', $this->input->post('home_contact_phone', TRUE));
        $this->save_pengaturan('home_contact_email', $this->input->post('home_contact_email', TRUE));
        $this->save_pengaturan('home_contact_address', $this->input->post('home_contact_address', TRUE));

        $this->session->set_flashdata('success', 'Konten bagian Tentang dan Kontak di halaman beranda berhasil diperbarui.');
        redirect('admin/homepage');
    }

    private function save_pengaturan($nama, $nilai)
    {
        $exists = $this->db->where('nama_pengaturan', $nama)->count_all_results('pengaturan');
        if ($exists > 0) {
            $this->db->update('pengaturan', ['nilai' => $nilai], ['nama_pengaturan' => $nama]);
        } else {
            $this->db->insert('pengaturan', [
                'nama_pengaturan' => $nama,
                'nilai' => $nilai
            ]);
        }
    }
}
