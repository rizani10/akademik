<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{
    

    public function setProfil()
    {

        $data =
            [
                'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
            ];

        $nama = $this->input->post('nama');
        $email = $this->input->post('email');


        // pengecekan gambar
        $upload_foto = $_FILES['foto']['name'];
        if ($upload_foto) {
            $config['upload_path'] = './assets/img/profil/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']     = '2048';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                // cek gambar lama jika default jagang di hapus
                $foto_lama = $data['user']['foto'];
                if ($foto_lama != 'default.jpg') {
                    unlink(FCPATH . 'assets/img/profil/' . $foto_lama);
                }
                $foto_baru = $this->upload->data('file_name');
                $this->db->set('foto', $foto_baru);
            } else {
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>'
                );

                redirect('user', 'refresh');
            }
        }

        $this->db->set('nama', $nama);
        $this->db->where('email', $email);
        $this->db->update('user');

        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Profil Berhasil Diedit</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>'
        );
        redirect('user');
    }


    public function getUbahPassword()
    {
        $data = [
            'user' => $this->db->get_where(
                'user',
                [
                    'email' => $this->session->userdata('email')
                ]
            )->row_array()
        ];

        // ambil password lama & pasword bar
        $passwordlama = $this->input->post('passwordlama');
        $passwordbaru = $this->input->post('passwordbaru1');


        // cek password lama sesuai apa tidak dengan database
        if (!password_verify($passwordlama, $data['user']['password'])) {
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Password Lama Salah!!!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('user/ubahpassword');
        } else {
            // cek password baru sama atau tidak dengan password lama
            if ($passwordlama == $passwordbaru) {
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Password Baru Tidak Boleh Sama Dengan Password Lama!!!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                );
                redirect('user/ubahpassword');
            } else {
                // password ok dan lakukan hash amankan
                $password_hash = password_hash($passwordbaru, PASSWORD_DEFAULT);

                $this->db->set('password', $password_hash);
                $this->db->where('email', $this->session->userdata('email'));
                $this->db->update('user');

                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Password Berhasil Diubah!!!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                );
                redirect('user/ubahpassword');
            }
        }
    }
}

/* End of file M_user.php */
