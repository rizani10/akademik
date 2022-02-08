<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        // pengecekan login lewan fungsi di dalam helper
        login();
        $this->load->model('M_user');
    }


    public function index()
    {
        $data = [
            'judul' => 'Halaman Utama',
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
        $this->load->view('user/profil');
        $this->load->view('template/footer', FALSE);
    }

    public function profil()
    {
        $data = [
            'judul' => 'Profil Saya',
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
        $this->load->view('user/profil');
        $this->load->view('template/footer', FALSE);
    }

    public function editprofil()
    {
        $data = [
            'judul' => 'Edit Profil',
            // ambil data user
            'user' => $this->db->get_where(
                'user',
                [
                    'email' => $this->session->userdata('email')
                ]
            )->row_array()
        ];

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('template/header', $data, FALSE);
            $this->load->view('template/sidebar', FALSE);
            $this->load->view('template/topbar', $data, FALSE);
            $this->load->view('user/editprofil');
            $this->load->view('template/footer', FALSE);
        } else {
            $this->M_user->setProfil();
        }
    }


    public function ubahpassword()
    {
        $data = [
            'judul' => 'Ubah Password',
            // ambil data user
            'user' => $this->db->get_where(
                'user',
                [
                    'email' => $this->session->userdata('email')
                ]
            )->row_array()
        ];

        $this->form_validation->set_rules('passwordlama', 'Password Lama', 'trim|required');
        $this->form_validation->set_rules('passwordbaru1', 'Password Baru', 'trim|required|min_length[6]|matches[passwordbaru2]');
        $this->form_validation->set_rules('passwordbaru2', 'Konfirmasi Password Baru', 'trim|required|min_length[6]|matches[passwordbaru1]');
        

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('template/header', $data, FALSE);
            $this->load->view('template/sidebar', FALSE);
            $this->load->view('template/topbar', $data, FALSE);
            $this->load->view('user/ubahpassword');
            $this->load->view('template/footer', FALSE);
        } else {
            $this->M_user->getUbahPassword();
        }
    }
}
/* End of file Home.php */
