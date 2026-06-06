<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petugas extends CI_Controller {

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
            'title'   => 'Data Petugas',
            'content' => 'admin/petugas',
            'petugas' => $this->M_user->get_all_petugas()
        ];
        $this->load->view('layouts/master', $data);
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nama', 'Nama Petugas', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $data_user = [
                'nama'     => $this->input->post('nama', TRUE),
                'email'    => $this->input->post('email', TRUE),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role'     => 'petugas'
            ];

            if ($this->M_user->insert_petugas($data_user)) {
                $this->session->set_flashdata('success', 'Data Petugas berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data.');
            }
            redirect('admin/petugas');
        }
    }

    public function hapus($id)
    {
        if ($this->M_user->delete_user($id)) {
            $this->session->set_flashdata('success', 'Data Petugas berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }
        redirect('admin/petugas');
    }
    public function ubah($id)
    {
        // Set aturan validasi data input
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Email Login', 'required|valid_email|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/petugas');
        } else {
            $data_update = [
                'nama'  => $this->input->post('nama', TRUE),
                'email' => $this->input->post('email', TRUE)
            ];

            // Enkripsi dan sisipkan password jika diisi oleh admin
            $password_baru = $this->input->post('password');
            if (!empty($password_baru)) {
                $data_update['password'] = password_hash($password_baru, PASSWORD_BCRYPT);
            }

            // Eksekusi pembaruan ke database (Sesuaikan dengan tabel user Anda)
            $this->db->where('id', $id);
            $this->db->update('users', $data_update); 

            $this->session->set_flashdata('success', 'Data petugas gerbang berhasil diperbarui.');
            redirect('admin/petugas');
        }
    }
}