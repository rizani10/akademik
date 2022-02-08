<?php
function login()
{
    // panggil instansiance
    $ci = get_instance();
    // pengecekan login lewat session
    if (!$ci->session->userdata('email')) {

        redirect('auth');
    } else {
        // pengecekenan role
        $role_id = $ci->session->userdata('role_id');
        // pengecekan menu lewat url
        $menu = $ci->uri->segment(1);


        // query tabel menu untuk mendapatkan id menu nya
        $queryMenu = $ci->db->get_where('user_menu', [
            'menu' => $menu
        ])->row_array();

        // ambil id nya dari query
        $menu_id = $queryMenu['id'];

        // query user akses
        $userAkses = $ci->db->get_where('user_akses_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);


        // pengecekan
        if ($userAkses->num_rows() < 1) {

            redirect('auth/block', 'refresh');
        }
    } 
}


// fungsi untuk cek akses dari role
function cek_akses($role_id, $menu_id)
{
    $ci = get_instance();

    // ambil role id dan menu id nya
    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_akses_menu');     //get ketabel user_akses_menu


    // lakukan pengecekan jika sesuai centang, jika tidak uncentang
    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}
