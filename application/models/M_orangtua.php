<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_orangtua extends CI_Model {

    // Ambil ID Orang Tua berdasarkan ID User yang sedang login
    public function get_id_ortu($id_user)
    {
        return $this->db->get_where('orang_tua', ['id_user' => $id_user])->row_array();
    }

    // Ambil semua anak yang terhubung dengan ID Orang Tua
    public function get_anak($id_orangtua)
    {
        return $this->db->get_where('siswa', ['id_orangtua' => $id_orangtua])->result_array();
    }

    // Ambil absensi hari ini untuk anak-anak tertentu
    public function get_absen_anak_hari_ini($id_orangtua)
    {
        $hari_ini = date('Y-m-d');
        $this->db->select('siswa.nama as nama_siswa, siswa.kelas, siswa.nis, absensi.jam_masuk, absensi.status');
        $this->db->from('siswa');
        $this->db->join('absensi', 'siswa.id_siswa = absensi.id_siswa AND absensi.tanggal = "' . $hari_ini . '"', 'left');
        $this->db->where('siswa.id_orangtua', $id_orangtua);
        return $this->db->get()->result_array();
    }

    // Ambil riwayat log absensi lengkap seluruh anak dari orang tua tersebut
    public function get_riwayat_lengkap($id_orangtua)
    {
        $this->db->select('absensi.*, siswa.nama as nama_siswa, siswa.kelas, siswa.nis');
        $this->db->from('absensi');
        $this->db->join('siswa', 'absensi.id_siswa = siswa.id_siswa', 'inner');
        $this->db->where('siswa.id_orangtua', $id_orangtua);
        $this->db->order_by('absensi.tanggal', 'DESC');
        $this->db->order_by('absensi.jam_masuk', 'DESC');
        return $this->db->get()->result_array();
    }
}