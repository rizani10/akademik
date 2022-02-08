<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        // pengecekan login lewan fungsi di dalam helper
        login();
        $this->load->model('M_role');
        $this->load->model('M_admin');
        
    }


    public function index()
    {
        $data = [
            'judul' => 'Dashboard',
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
        $this->load->view('admin/index');
        $this->load->view('template/footer', FALSE);
    }

    public function profil()
    {
        $data = [
            'judul' => 'Halaman Profil',
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
        $this->load->view('admin/profil');
        $this->load->view('template/footer', FALSE);
    }


    public function role()
    {
        $data = [
            'judul' => 'Role Akses',
            // ambil data user
            'user' => $this->db->get_where(
                'user',
                [
                    'email' => $this->session->userdata('email')
                ]
            )->row_array(),
            'role' => $this->M_role->getAllRole()
        ];

        $this->load->view('template/header', $data, FALSE);
        $this->load->view('template/sidebar', FALSE);
        $this->load->view('template/topbar', $data, FALSE);
        $this->load->view('admin/role');
        $this->load->view('template/footer', FALSE);
    }


    public function roleakses($role_id)
    {
        $data = [
            'judul' => 'Role Akses',
            // ambil data user
            'user' => $this->db->get_where(
                'user',
                [
                    'email' => $this->session->userdata('email')
                ]
            )->row_array(),
            'role' => $this->M_role->getRoleById($role_id),
            'menu' => $this->M_role->getMenu()
        ];

        $this->load->view('template/header', $data, FALSE);
        $this->load->view('template/sidebar', FALSE);
        $this->load->view('template/topbar', $data, FALSE);
        $this->load->view('admin/roleakses');
        $this->load->view('template/footer', FALSE);
    }


    public function ubahakses()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');
        

        // siapkan data buat masukkan ke database
        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        // siapkan database
        $result = $this->db->get_where('user_akses_menu' , $data);

        // cek jika datanya tidak ada insert database
        if ($result->num_rows() < 1) {
            $this->db->insert('user_akses_menu', $data);
            
        } else {
            // jika datanya ada silahkan hapus
            $this->db->delete('user_akses_menu', $data);
            
        }

        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Role Akses Berhasil Diubah</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>'
        );
    }


    public function daftaruser()
    {
        $data = [
            'judul' => 'Managemen User',
            // ambil data user
            'user' => $this->db->get_where(
                'user',
                [
                    'email' => $this->session->userdata('email')
                ]
            )->row_array(),
            'usr' => $this->M_admin->getUser(),
            'role' => $this->M_admin->getRole()
        ];
        $this->load->view('template/header', $data, FALSE);
        $this->load->view('template/sidebar', FALSE);
        $this->load->view('template/topbar', $data, FALSE);
        $this->load->view('admin/daftaruser');
        $this->load->view('template/footer', FALSE);
    }

    public function editrole()
    {
        $this->M_admin->getEditRole();
    }
}
/* End of file Home.php */
