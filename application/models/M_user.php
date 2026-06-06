<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

    // ================= PETUGAS MANAGEMENT =================
    public function get_all_petugas()
    {
        return $this->db->get_where('users', ['role' => 'petugas'])->result_array();
    }

    public function insert_petugas($data_user)
    {
        return $this->db->insert('users', $data_user);
    }

    // ================= ORANG TUA MANAGEMENT =================
    public function get_all_orangtua()
    {
        $this->db->select('orang_tua.*, users.email');
        $this->db->from('orang_tua');
        $this->db->join('users', 'orang_tua.id_user = users.id');
        return $this->db->get()->result_array();
    }

    public function insert_orangtua($data_user, $data_ortu)
    {
        $this->db->trans_start();
        
        // Input ke tabel users terlebih dahulu
        $this->db->insert('users', $data_user);
        $id_user = $this->db->insert_id();
        
        // Input ke tabel orang_tua dengan id_user barusan
        $data_ortu['id_user'] = $id_user;
        $this->db->insert('orang_tua', $data_ortu);
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // ================= GENERAL METHOD =================
    public function delete_user($id)
    {
        // Karena ada foreign key ON DELETE CASCADE, menghapus user otomatis menghapus profil orang tua
        return $this->db->delete('users', ['id' => $id]);
    }
    public function get_all_admin()
    {
        return $this->db->get_where('users', ['role' => 'admin'])->result_array();
    }

    public function insert_admin($data_user)
    {
        return $this->db->insert('users', $data_user);
    }

    public function get_user_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row_array();
    }

    public function update_user($id, $data)
    {
        return $this->db->update('users', $data, ['id' => $id]);
    }

}