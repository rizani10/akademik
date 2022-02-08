<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_menu extends CI_Model
{
    public function getAll()
    {
        $this->db->select('*');
        $this->db->from('user_menu');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result_array();
    }

    public function insert()
    {
        $data = [
            'menu' => htmlspecialchars($this->input->post('menu', true))
        ];

        $this->db->insert('user_menu', $data);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Menu Baru Berhasil Ditambah</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>'
        );
        redirect('menu');
    }

    public function getEdit()
    {
        $data = [
            'menu' => htmlspecialchars($this->input->post('menu', true))
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_menu', $data);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Menu Berhasil Diedit</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>'
        );
        redirect('menu');
    }

    public function getHapus($id)
    {
        $this->db->delete('user_menu', ['id' => $id]);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Menu Berhasil Dihapus</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>'
        );
        redirect('menu');
    }


    public function getSubMenu()
    {
        // query table sub menu dan table menu
        $querySubMenu = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                        FROM `user_sub_menu`
                        JOIN `user_menu`
                        ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                        ORDER by `user_sub_menu`.`id` DESC
                    ";
        return $this->db->query($querySubMenu)->result_array();
    }

    public  function insertSubMenu()
    {
        $data = [
            'menu_id' => htmlspecialchars($this->input->post('menu_id')),
            'judul' => htmlspecialchars($this->input->post('judul')),
            'url' => htmlspecialchars($this->input->post('url')),
            'icon' => htmlspecialchars($this->input->post('icon')),
            'aktive' => htmlspecialchars($this->input->post('aktive'))
        ];

        $this->db->insert('user_sub_menu', $data);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Submenu Baru Berhasil Ditambah</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>'
        );
        redirect('menu/submenu');
    }


    public function getEditSubmenu()
    {
        $data = [
            'menu_id' => htmlspecialchars($this->input->post('menu_id')),
            'judul' => htmlspecialchars($this->input->post('judul')),
            'url' => htmlspecialchars($this->input->post('url')),
            'icon' => htmlspecialchars($this->input->post('icon')),
            'aktive' => htmlspecialchars($this->input->post('aktive'))
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_sub_menu', $data);

        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Submenu Berhasil Diubah</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>'
        );
        redirect('menu/submenu');
    }

    public function getSubMenuHapus($id)
    {
        $this->db->delete('user_sub_menu', ['id' => $id]);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Submenu Berhasil Dihapus</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>'
        );
        redirect('menu/submenu');
    }
}

/* End of file M_menu.php */
