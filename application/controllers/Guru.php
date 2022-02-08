<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Guru extends CI_Controller
{

    public function index()
    {
        $data = [
            'judul' => 'Guru',
            // ambil data user
            'user' => $this->db->get_where(
                'user',
                [
                    'email' => $this->session->userdata('email')
                ]
            )->row_array()
        ];
        $this->load->view('template/header', $data, FALSE);
        $this->load->view('template/sidebar', FALSE);
        $this->load->view('template/topbar', $data, FALSE);
        $this->load->view('gtk/index');
        $this->load->view('template/footer', FALSE);
    }



    public function tambah()
    {
        $data = [
            'judul' => 'Guru',
            // ambil data user
            'user' => $this->db->get_where(
                'user',
                [
                    'email' => $this->session->userdata('email')
                ]
            )->row_array()
        ];
        $this->load->view('template/header', $data, FALSE);
        $this->load->view('template/sidebar', FALSE);
        $this->load->view('template/topbar', $data, FALSE);
        $this->load->view('gtk/tambah');
        $this->load->view('template/footer', FALSE);
    }
}



/* End of file Gtk.php */
