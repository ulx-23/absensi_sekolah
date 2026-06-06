<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

    public function cek_email($email)
    {
        // Mencari data user berdasarkan email
        return $this->db->get_where('users', ['email' => $email])->row_array();
    }
}