<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sliders extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Slider_model');
        $this->load->library('form_validation');
        // Pastikan ada proteksi session login admin di sini jika diperlukan
    }

    public function index()
    {
        $data['title'] = "Kelola Slider Homepage";
        $data['sliders'] = $this->Slider_model->get_all();

        // Menentukan view mana yang akan disisipkan ke tengah-tengah master template
        $data['content'] = 'admin/sliders/manage_sliders'; 

        // Memanggil master layout
        $this->load->view('layouts/master', $data); 
    }

    public function tambah()
    {
        $this->form_validation->set_rules('judul', 'Judul Slider', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('tipe_media', 'Tipe Media', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/sliders');
        } else {
            $tipe_media = $this->input->post('tipe_media', TRUE);
            $file_media_value = '';

            // LOGIKA 1: Jika memilih Gambar, lakukan proses Upload
            if ($tipe_media == 'image') {
                $config['upload_path']   = './uploads/sliders/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 5120; // Batas 5MB untuk gambar
                $config['encrypt_name']  = TRUE;

                $this->load->library('upload', $config);

                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }

                if (!$this->upload->do_upload('file_media')) {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('admin/sliders');
                    return;
                } else {
                    $upload_data = $this->upload->data();
                    $file_media_value = $upload_data['file_name'];
                }
            } 
            // LOGIKA 2: Jika memilih Video, ambil dari input text URL YouTube
            else if ($tipe_media == 'video') {
                $link_youtube = $this->input->post('link_youtube', TRUE);
                if (empty($link_youtube)) {
                    $this->session->set_flashdata('error', 'Link YouTube wajib diisi jika tipe media adalah video.');
                    redirect('admin/sliders');
                    return;
                }
                $file_media_value = $link_youtube;
            }

            // Eksekusi Insert Data
            $data_insert = [
                'tipe_media'  => $tipe_media,
                'file_media'  => $file_media_value,
                'judul'       => $this->input->post('judul', TRUE),
                'deskripsi'   => $this->input->post('deskripsi', TRUE),
                'teks_tombol' => $this->input->post('teks_tombol', TRUE),
                'link_tombol' => $this->input->post('link_tombol', TRUE),
                'status'      => $this->input->post('status', TRUE)
            ];

            $this->Slider_model->insert($data_insert);
            $this->session->set_flashdata('success', 'Slider baru berhasil dipublikasikan.');
            redirect('admin/sliders');
        }
    }

    public function ubah($id)
    {
        $slider_lama = $this->Slider_model->get_by_id($id);
        if (!$slider_lama) redirect('admin/sliders');

        $tipe_media = $this->input->post('tipe_media', TRUE);

        $data_update = [
            'tipe_media'  => $tipe_media,
            'judul'       => $this->input->post('judul', TRUE),
            'deskripsi'   => $this->input->post('deskripsi', TRUE),
            'teks_tombol' => $this->input->post('teks_tombol', TRUE),
            'link_tombol' => $this->input->post('link_tombol', TRUE),
            'status'      => $this->input->post('status', TRUE)
        ];

        // LOGIKA 1: Update untuk Gambar
        if ($tipe_media == 'image') {
            if (!empty($_FILES['file_media']['name'])) {
                $config['upload_path']   = './uploads/sliders/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 5120;
                $config['encrypt_name']  = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file_media')) {
                    // Hapus gambar lama JIKA tipe sebelumnya juga gambar
                    if ($slider_lama['tipe_media'] == 'image') {
                        $path_lama = './uploads/sliders/' . $slider_lama['file_media'];
                        if (file_exists($path_lama)) {
                            unlink($path_lama);
                        }
                    }

                    $upload_data = $this->upload->data();
                    $data_update['file_media'] = $upload_data['file_name'];
                }
            }
        } 
        // LOGIKA 2: Update untuk Video YouTube
        else if ($tipe_media == 'video') {
            $link_youtube = $this->input->post('link_youtube', TRUE);
            if (!empty($link_youtube)) {
                $data_update['file_media'] = $link_youtube;
            }

            // Bersihkan file server JIKA sebelumnya adalah gambar lalu diubah menjadi video
            if ($slider_lama['tipe_media'] == 'image') {
                $path_lama = './uploads/sliders/' . $slider_lama['file_media'];
                if (file_exists($path_lama)) {
                    unlink($path_lama);
                }
            }
        }

        $this->Slider_model->update($id, $data_update);
        $this->session->set_flashdata('success', 'Informasi komponen slider berhasil diperbarui.');
        redirect('admin/sliders');
    }

    public function hapus($id)
    {
        $slider = $this->Slider_model->get_by_id($id);
        if ($slider) {
            // Hanya hapus file fisik (unlink) jika tipenya adalah gambar
            if ($slider['tipe_media'] == 'image') {
                $path = './uploads/sliders/' . $slider['file_media'];
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $this->Slider_model->delete($id);
            $this->session->set_flashdata('success', 'Slider berhasil dihapus secara permanen.');
        }
        redirect('admin/sliders');
    }
}