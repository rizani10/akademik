<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_role extends CI_Model {

    public function getAllRole()
    {
        $this->db->select('*');
        $this->db->from('user_role');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result_array();
        
    }
    

    public function getRoleById($role_id)
    {
        $this->db->select('*');
        $this->db->from('user_role');
        $this->db->where('id', $role_id);
        return $this->db->get()->row_array();
        
    }

    public function getMenu()
    {
        $this->db->select('*');
        $this->db->from('user_menu');
        // $this->db->where('id !=', 1);
        return $this->db->get()->result_array();
        
    }



}

/* End of file M_role.php */
