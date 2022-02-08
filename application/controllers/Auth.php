<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_auth');
    }


    public function index()
    {


        // pengecekan jika sudah ada session dilarang masuk ke halaman auth
        if ($this->session->userdata('email')) {

            redirect('user', 'refresh');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login', FALSE);
        } else {
            $this->M_auth->login();
        }
    }

    public function registrasi()
    {

        // pengecekan jika sudah ada session dilarang masuk ke halaman auth
        if ($this->session->userdata('email')) {

            redirect('user', 'refresh');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email Sudah Terdaftar!'
        ]);
        $this->form_validation->set_rules(
            'password',
            'Password',
            'trim|required|min_length[3]|matches[pass2]',
            [
                'matches' => 'Password Tidak Sama!',
                'min_length' => 'Password Terlalu Pendek!'
            ]
        );
        $this->form_validation->set_rules('pass2', 'Password', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/registrasi', FALSE);
        } else {
            $this->M_auth->insert();
        }
    }

    public function logout()
    {

        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Kamu Telah Keluar Dari Aplikasi</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>'
        );
        redirect('auth');
    }


    public function block()
    {
        $data = [
            'judul' => 'Halaman Tidak Dapat Diakses'
        ];

        $this->load->view('template/header', $data, FALSE);
        $this->load->view('auth/block', FALSE);
        $this->load->view('template/footer', FALSE);
    }



    // fungsi verifikasi email dan token
    public function verify()
    {
        $this->M_auth->getVerify();
    }
    // fungsi verifikasi email dan token



    public function lupapassword()
    {

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/lupa-password', FALSE);
        } else {
            $this->M_auth->getLupaPassword();
        }
    }



    public function resetpassword()
    {
        $this->M_auth->getResetPassword();
    }


    public function getUbahPassword()
    {

        // agar tidak bisa di akses tanpa ada token dan email
        if (! $this->session->userdata('reset_email')) {
            
            redirect('auth','refresh');
            
        }

        $this->form_validation->set_rules(
            'password1',
            'Password',
            'trim|required|min_length[6]|matches[password2]',
            [
                'matches' => 'Password Tidak Sama!',
                'min_length' => 'Password Terlalu Pendek!'
            ]
        );

        $this->form_validation->set_rules(
            'password2',
            'Password',
            'trim|required|min_length[6]|matches[password1]',
            [
                'matches' => 'Password Tidak Sama!',
                'min_length' => 'Password Terlalu Pendek!'
            ]
        );


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/ubah-password', FALSE);
        } else {
            $password =  password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            // edit tabel user
            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            // hapus session reset email
            $this->session->unset_userdata('reset_email');

            // direct
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Password Berhasil Diubah, Silahkan Login</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('auth');
        }
    }
}

/* End of file Auth.php */
