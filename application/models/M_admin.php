<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_admin extends CI_Model
{

    public function getUser()
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('user_role', 'user_role.id = user.role_id', 'left');
        $this->db->order_by('tgl_buat', 'desc');
        return $this->db->get()->result_array();
    }

    public function getRole()
    {
        $this->db->select('*');
        $this->db->from('user_role');
        return $this->db->get()->result_array();
    }

    public function getEditRole()
    {
        $email = $this->input->post('email');
        $role_id = $this->input->post('role_id');
        
        $this->db->set('role_id' , $role_id);
        $this->db->where('email', $email);
        $this->db->update('user');
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Role Untuk Email : '. $email .' Berhasil Diubah</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>'
        );
        redirect('admin/daftaruser');
    }
}

/* End of file M_admin.php */
