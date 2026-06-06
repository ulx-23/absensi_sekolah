<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_akademik extends CI_Model {

    // ================= CRUD KELAS =================
    public function get_all_kelas() {
        return $this->db->get('siswa_kelas')->result_array();
    }

    public function insert_kelas($data) {
        return $this->db->insert('siswa_kelas', $data);
    }

    public function update_kelas($id, $data) {
        return $this->db->update('siswa_kelas', $data, ['id_kelas' => $id]);
    }

    public function delete_kelas($id) {
        return $this->db->delete('siswa_kelas', ['id_kelas' => $id]);
    }

    // ================= CRUD TAHUN AJARAN =================
    public function get_all_tahun() {
        return $this->db->get('tahun_ajaran')->result_array();
    }

    public function insert_tahun($data) {
        return $this->db->insert('tahun_ajaran', $data);
    }

    public function update_tahun($id, $data) {
        return $this->db->update('tahun_ajaran', $data, ['id_tahun' => $id]);
    }

    public function set_aktif_tahun($id) {
        $this->db->trans_start();
        // Ubah semua status menjadi tidak aktif terlebih dahulu
        $this->db->update('tahun_ajaran', ['status' => 'tidak_aktif']);
        // Aktifkan tahun ajaran yang dipilih
        $this->db->update('tahun_ajaran', ['status' => 'aktif'], ['id_tahun' => $id]);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete_tahun($id) {
        return $this->db->delete('tahun_ajaran', ['id_tahun' => $id]);
    }

    // ================= CRUD SISWA (Eksisting) =================
    public function get_all_siswa() {
        $this->db->select('siswa.*, orang_tua.nama as nama_ortu');
        $this->db->from('siswa');
        $this->db->join('orang_tua', 'siswa.id_orangtua = orang_tua.id_orangtua', 'left');
        return $this->db->get()->result_array();
    }

    public function insert_siswa($data) {
        return $this->db->insert('siswa', $data);
    }

    public function update_siswa($id, $data) {
        return $this->db->update('siswa', $data, ['id_siswa' => $id]);
    }

    public function delete_siswa($id) {
        return $this->db->delete('siswa', ['id_siswa' => $id]);
    }
}