<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider_model extends CI_Model {

    public function get_all()
    {
        $this->db->order_by('id_slider', 'DESC');
        return $this->db->get('frontend_sliders')->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('frontend_sliders', ['id_slider' => $id])->row_array();
    }

    public function insert($data)
    {
        return $this->db->insert('frontend_sliders', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id_slider', $id);
        return $this->db->update('frontend_sliders', $data);
    }

    public function delete($id)
    {
        $this->db->where('id_slider', $id);
        return $this->db->delete('frontend_sliders');
    }
}