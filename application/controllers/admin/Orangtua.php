<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orangtua extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
        $this->load->model('M_user');
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Orang Tua',
            'content'   => 'admin/orang_tua',
            'orang_tua' => $this->M_user->get_all_orangtua()
        ];
        $this->load->view('layouts/master', $data);
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nama', 'Nama Orang Tua', 'required|trim');
        $this->form_validation->set_rules('hp', 'Nomor HP', 'required|numeric|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $data_user = [
                'nama'     => $this->input->post('nama', TRUE),
                'email'    => $this->input->post('email', TRUE),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role'     => 'orangtua'
            ];

            $data_ortu = [
                'nama'  => $this->input->post('nama', TRUE),
                'hp'    => $this->input->post('hp', TRUE),
                'email' => $this->input->post('email', TRUE),
            ];

            if ($this->M_user->insert_orangtua($data_user, $data_ortu)) {
                $this->session->set_flashdata('success', 'Data Orang Tua berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data.');
            }
            redirect('admin/orangtua');
        }
    }

    public function hapus($id_user)
    {
        if ($this->M_user->delete_user($id_user)) {
            $this->session->set_flashdata('success', 'Data Orang Tua berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }
        redirect('admin/orangtua');
    }
    public function ubah($id_user)
    {
        // Validasi input data dari form
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('hp', 'Nomor HP', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/orangtua');
        } else {
            $data_update = [
                'nama'  => $this->input->post('nama', TRUE),
                'hp'    => $this->input->post('hp', TRUE),
                'email' => $this->input->post('email', TRUE)
            ];

            // Jika admin menginputkan perubahan kredensial password baru
            $password_baru = $this->input->post('password');
            if (!empty($password_baru)) {
                $data_update['password'] = password_hash($password_baru, PASSWORD_BCRYPT);
            }

            // Eksekusi update data (Sesuaikan dengan nama model user/ortu Anda)
            $this->db->where('id_user', $id_user);
            $this->db->update('orang_tua', $data_update); 

            $this->session->set_flashdata('success', 'Data orang tua berhasil diperbarui.');
            redirect('admin/orangtua');
        }
    }
}