<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_manage extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
        $this->load->model('M_user');
    }

    // --- KELOLA DATA ADMIN ---
    public function index()
    {
        $data = [
            'title'   => 'Data Administrator',
            'content' => 'admin/admin_list',
            'admins'  => $this->M_user->get_all_admin()
        ];
        $this->load->view('layouts/master', $data);
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nama', 'Nama Admin', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $data_user = [
                'nama'     => $this->input->post('nama', TRUE),
                'email'    => $this->input->post('email', TRUE),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role'     => 'admin'
            ];

            $this->M_user->insert_admin($data_user);
            $this->session->set_flashdata('success', 'Administrator baru berhasil ditambahkan.');
            redirect('admin/admin_manage');
        }
    }

    public function hapus($id)
    {
        // Mencegah admin menghapus akun dirinya sendiri secara tidak sengaja
        if ($id == $this->session->userdata('id_user')) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
            redirect('admin/admin_manage');
        }

        $this->M_user->delete_user($id);
        $this->session->set_flashdata('success', 'Data administrator berhasil dihapus.');
        redirect('admin/admin_manage');
    }

    // --- EDIT PROFIL SAYA ---
    public function profil()
    {
        $id_user = $this->session->userdata('id_user');
        
        $data = [
            'title'   => 'Edit Profil Saya',
            'content' => 'admin/profil_edit',
            'user'    => $this->M_user->get_user_by_id($id_user)
        ];
        $this->load->view('layouts/master', $data);
    }

    public function proses_update_profil()
    {
        $id_user = $this->session->userdata('id_user');
        $user_sekarang = $this->M_user->get_user_by_id($id_user);

        $email_input = $this->input->post('email', TRUE);

        if ($email_input != $user_sekarang['email']) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|trim');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        }
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->profil();
        } else {
            $data_update = [
                'nama'  => $this->input->post('nama', TRUE),
                'email' => $email_input
            ];

            // --- PROSES UPLOAD FOTO PROFIL ---
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path']   = './uploads/profile/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = 2048; // Batas Maksimal 2MB
                $config['file_name']     = 'avatar_' . $id_user . '_' . time(); // Enkripsi nama file

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data();
                    $data_update['foto'] = $upload_data['file_name'];

                    // Hapus file foto lama di server jika ada dan bukan default
                    if (!empty($user_sekarang['foto']) && file_exists('./uploads/profile/' . $user_sekarang['foto'])) {
                        unlink('./uploads/profile/' . $user_sekarang['foto']);
                    }
                }
            }

            // Cek inputan password baru
            $password_baru = $this->input->post('password');
            if (!empty($password_baru)) {
                $data_update['password'] = password_hash($password_baru, PASSWORD_BCRYPT);
            }

            $this->M_user->update_user($id_user, $data_update);

            // Ambil data terbaru untuk sinkronisasi session
            $user_terbaru = $this->M_user->get_user_by_id($id_user);
            $this->session->set_userdata('nama', $user_terbaru['nama']);
            $this->session->set_userdata('email', $user_terbaru['email']);
            if (isset($user_terbaru['foto'])) {
                $this->session->set_userdata('foto', $user_terbaru['foto']);
            }

            $this->session->set_flashdata('success', 'Profil dan foto Anda berhasil diperbarui.');
            redirect('admin/admin_manage/profil');
        }
    }
    public function ubah()
    {
        $id_admin = $this->input->post('id_admin', TRUE);
        $user_sekarang = $this->M_user->get_user_by_id($id_admin);
        $email_input = $this->input->post('email', TRUE);

        if ($email_input != $user_sekarang['email']) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|trim');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        }
        $this->form_validation->set_rules('nama', 'Nama Admin', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/admin_manage');
        } else {
            $data_update = [
                'nama'  => $this->input->post('nama', TRUE),
                'email' => $email_input
            ];

            // Jika admin mengisi kolom password baru, enkripsi dan perbarui
            $password_baru = $this->input->post('password');
            if (!empty($password_baru)) {
                $data_update['password'] = password_hash($password_baru, PASSWORD_BCRYPT);
            }

            $this->M_user->update_user($id_admin, $data_update);
            $this->session->set_flashdata('success', 'Data administrator berhasil diperbarui.');
            redirect('admin/admin_manage');
        }
    }
}