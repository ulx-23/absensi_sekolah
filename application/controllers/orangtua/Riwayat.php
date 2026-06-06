<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'orangtua') {
            redirect('auth');
        }
        $this->load->model('M_orangtua');
    }

    public function index() {
        $id_user = $this->session->userdata('id_user');
        $ortu = $this->M_orangtua->get_id_ortu($id_user);

        $data = [
            'title'   => 'Riwayat Absensi Lengkap',
            'content' => 'orangtua/riwayat_view',
            'riwayat' => $ortu ? $this->M_orangtua->get_riwayat_lengkap($ortu['id_orangtua']) : []
        ];
        $this->load->view('layouts/master', $data);
    }
}