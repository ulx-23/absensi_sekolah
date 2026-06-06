<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

 public function index()
{
    // Mengambil data dari database (seperti tahap sebelumnya)
    $this->db->where('status', 'aktif');
    $this->db->order_by('id_slider', 'DESC');
    $data['sliders'] = $this->db->get('frontend_sliders')->result_array();

    // Ambil konten dinamis untuk halaman utama dari tabel pengaturan
    $config_data = $this->db->get('pengaturan')->result_array();
    $pengaturan = [];
    foreach ($config_data as $row) {
        $pengaturan[$row['nama_pengaturan']] = $row['nilai'];
    }

    $data['home_about_title'] = isset($pengaturan['home_about_title']) ? $pengaturan['home_about_title'] : 'Kenali E-Absensi Lebih Dekat';
    $data['home_about_subtitle'] = isset($pengaturan['home_about_subtitle']) ? $pengaturan['home_about_subtitle'] : 'Solusi absensi modern untuk sekolah yang lebih efektif';
    $data['home_about_description'] = isset($pengaturan['home_about_description']) ? $pengaturan['home_about_description'] : 'E-Absensi hadir untuk memudahkan proses kehadiran siswa dengan sistem QR Code, laporan terpadu, dan keamanan gerbang sekolah secara real-time.';

    $data['home_contact_title'] = isset($pengaturan['home_contact_title']) ? $pengaturan['home_contact_title'] : 'Hubungi Kami';
    $data['home_contact_subtitle'] = isset($pengaturan['home_contact_subtitle']) ? $pengaturan['home_contact_subtitle'] : 'Tim kami siap membantu setiap kebutuhan sekolah dan wali murid.';
    $data['home_contact_phone'] = isset($pengaturan['home_contact_phone']) ? $pengaturan['home_contact_phone'] : '+62 812-3456-7890';
    $data['home_contact_email'] = isset($pengaturan['home_contact_email']) ? $pengaturan['home_contact_email'] : 'info@e-absensi.sch.id';
    $data['home_contact_address'] = isset($pengaturan['home_contact_address']) ? $pengaturan['home_contact_address'] : 'Jl. Pendidikan No. 10, Kota Pendidikan, Indonesia';
    
    // Menyiapkan judul halaman web untuk dilempar ke header
    $data['title'] = "E-Absensi - Selamat Datang";

    // Teknik Memanggil View yang Telah Dipecah (Secara Berurutan)
    $this->load->view('frontend/layout/header', $data);
    $this->load->view('frontend/home', $data); // Konten berada di tengah
    $this->load->view('frontend/layout/footer');
}
}