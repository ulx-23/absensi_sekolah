<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan extends CI_Model {

    public function get_filter_absensi($tgl_mulai = null, $tgl_selesai = null, $kelas = null)
    {
        $this->db->select('absensi.*, siswa.nama as nama_siswa, siswa.nis, siswa.kelas, users.nama as nama_petugas');
        $this->db->from('absensi');
        $this->db->join('siswa', 'absensi.id_siswa = siswa.id_siswa', 'inner');
        $this->db->join('users', 'absensi.id_petugas = users.id', 'left');

        // Filter berdasarkan tanggal jika diisi
        if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
            $this->db->where('absensi.tanggal >=', $tgl_mulai);
            $this->db->where('absensi.tanggal <=', $tgl_selesai);
        }

        // Filter berdasarkan kelas jika diisi
        if (!empty($kelas)) {
            $this->db->where('siswa.kelas', $kelas);
        }

        $this->db->order_by('absensi.tanggal', 'DESC');
        $this->db->order_by('absensi.jam_masuk', 'DESC');
        
        return $this->db->get()->result_array();
    }

    public function get_absensi_hari_ini()
    {
        $hari_ini = date('Y-m-d');
        $this->db->select('absensi.*, siswa.nama as nama_siswa, siswa.nis, siswa.kelas, users.nama as nama_petugas');
        $this->db->from('absensi');
        $this->db->join('siswa', 'absensi.id_siswa = siswa.id_siswa', 'inner');
        $this->db->join('users', 'absensi.id_petugas = users.id', 'left');
        $this->db->where('absensi.tanggal', $hari_ini);
        $this->db->order_by('absensi.jam_masuk', 'DESC');
        
        return $this->db->get()->result_array();
    }
}