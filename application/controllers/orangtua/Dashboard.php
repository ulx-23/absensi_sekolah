<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
            'title'   => 'Status Kehadiran Anak',
            'content' => 'orangtua/dashboard_view',
            'anak'    => $ortu ? $this->M_orangtua->get_absen_anak_hari_ini($ortu['id_orangtua']) : []
        ];
        $this->load->view('layouts/master', $data);
    }
}