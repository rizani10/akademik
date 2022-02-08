<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_menu');
        // pengecekan login lewan fungsi di dalam helper
        login();
    }


    public function index()
    {
        $data = [
            'judul' => 'Menu Managemen',
            // ambil data user
            'user' => $this->db->get_where(
                'user',
                [
                    'email' => $this->session->userdata('email')
                ]
            )->row_array(),
            'menu' => $this->M_menu->getAll()
        ];

        $this->form_validation->set_rules('menu', 'Menu', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('template/header', $data, FALSE);
            $this->load->view('template/sidebar', FALSE);
            $this->load->view('template/topbar', $data, FALSE);
            $this->load->view('menu/index', $data);
            $this->load->view('template/footer', FALSE);
        } else {
            $this->M_menu->insert();
        }
    }

    public function edit()
    {
        $this->M_menu->getEdit();
    }

    public function hapus($id)
    {
        $this->M_menu->getHapus($id);
    }

    
    public function subMenu()
    {
        $data = [
            'judul' => 'Submenu Managemen',
            // ambil data user
            'user' => $this->db->get_where(
                'user',
                [
                    'email' => $this->session->userdata('email')
                ]
            )->row_array(),
            'subMenu' => $this->M_menu->getSubMenu(),
            'menu' => $this->M_menu->getAll()
        ];

        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'trim|required');
        $this->form_validation->set_rules('url', 'Url', 'trim|required');
        $this->form_validation->set_rules('icon', 'Icon', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('template/header', $data, FALSE);
            $this->load->view('template/sidebar', FALSE);
            $this->load->view('template/topbar', $data, FALSE);
            $this->load->view('menu/submenu', $data);
            $this->load->view('template/footer', FALSE);
        } else {
            $this->M_menu->insertSubMenu();
        }
    }



    public function editsubmenu()
    {
        $this->M_menu->getEditSubmenu();
    }

    public function hapussubmenu($id)
    {
        $this->M_menu->getSubMenuHapus($id);
    }
}
