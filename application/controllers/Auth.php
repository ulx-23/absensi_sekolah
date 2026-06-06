<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_auth');
    }

    public function index()
    {
        // Jika sudah login, langsung arahkan sesuai role masing-masing
        if ($this->session->userdata('logged_in')) {
            $this->_redirect_by_role($this->session->userdata('role'));
        }

        $this->load->view('login');
    }

    public function proses_login()
    {
        // Aturan validasi form
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $email    = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);

            // Perbaikan: Menggunakan tanda panah (->) untuk memanggil model
            $user = $this->M_auth->cek_email($email);

            if ($user) {
                // Verifikasi password berkriptografi BCRYPT
                if (password_verify($password, $user['password'])) {
                    
                    // Siapkan data session
                    $session_data = [
                        'id_user'   => $user['id'],
                        'nama'      => $user['nama'],
                        'email'     => $user['email'],
                        'role'      => $user['role'],
                        'foto'      => $user['foto'],
                        'logged_in' => TRUE
                    ];
                    $this->session->set_userdata($session_data);

                    // Redirect berdasarkan role
                    $this->_redirect_by_role($user['role']);

                } else {
                    $this->session->set_flashdata('error', 'Password yang Anda masukkan salah.');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('error', 'Email tidak terdaftar.');
                redirect('auth');
            }
        }
    }

    private function _redirect_by_role($role)
    {
        if ($role == 'admin') {
            redirect('admin/dashboard');
        } elseif ($role == 'petugas') {
            redirect('petugas/dashboard');
        } elseif ($role == 'orangtua') {
            redirect('orangtua/dashboard');
        } else {
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}