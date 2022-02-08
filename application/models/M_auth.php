<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_auth extends CI_Model
{

    public function insert()
    {
        $data = [
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'foto' => 'default.jpg',
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role_id' => 2,
            'active' => 0,
            'tgl_buat' => time()
        ];


        // siapkan token
        $token = base64_encode(random_bytes(32));
        // siapkan table baru untuk menyimpan token sementara
        $user_token = [
            'email'     =>  htmlspecialchars($this->input->post('email', true)),
            'token'      => $token,
            'tgl_buat'  => time()
        ];

        $this->db->insert('user', $data);
        // insert kedalam table user_token
        $this->db->insert('user_token', $user_token);

        // lakukan kirim email untuk aktivasi (menggunakan modifier private function)
        $this->_kirimEmail($token, 'verify');


        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Selamat, Akun Berhasil Dibuat Dan Lakukan Aktivasi</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>'
        );
        redirect('auth');
    }


    // private fungsi kirim email
    private function _kirimEmail($token, $type)
    {
        // konfigurasi
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'faisal.mr.rizani@gmail.com',
            'smtp_pass' => 'Rizani290400',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        // siapkan emailnya, dari saya
        $this->email->from('faisal.mr.rizani@gmail.com', 'Muhammad Faisal');
        // kirim ke
        $this->email->to($this->input->post('email'));


        // cek typenya
        if ($type == 'verify') {
            // subjek email
            $this->email->subject('Silahkan Aktifasi Akun');
            // body email
            $this->email->message('Silahkan Klik Link Untuk Melakukan Verifikasi Akun : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '"> Silahkan Aktivasi </a> ');
        } else if ($type = 'lupapassword') {
            // subjek email
            $this->email->subject('Reset Password');
            // body email
            $this->email->message('Silahkan Klik Link Untuk Melakukan Reset Password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '"> Silahkan Reset Password </a> ');
        }

        // kirim emailnya
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }


    // fungsi verifikasi email dan token
    public function getVerify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        // ambil user berdasarkan email di dalam database
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        // cek jika ada usernya
        if ($user) {
            // cek token nya apakah valid atau tidak
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                // cek waktu token 
                if (time() - $user_token['tgl_buat'] < (120)) {
                    // jika lulus pengecekan
                    $this->db->set('active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');


                    // lakukan hapus tokennya
                    $this->db->delete('user_token', ['email' => $email]);

                    // buat flashdatanya
                    $this->session->set_flashdata(
                        'pesan',
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>' . $email . ' Berhasil Diaktivasi, Silahkan Login!!</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>'
                    );
                    redirect('auth');
                } else {

                    // hapus data user dan user tokennya
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);


                    $this->session->set_flashdata(
                        'pesan',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Token Expired, Silahkan Registrasi Ulang!!</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>'
                    );
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Token Tidak Valid Silahkan Periksa Data!!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                );
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Akun Gagal Diaktivasi, Kesalahan Email!!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('auth');
        }
    }


    // fungsi reset paassword
    public function getLupaPassword()
    {
        $email = $this->input->post('email');
        $user_email = $this->db->get_where('user', ['email' => $email, 'active' => 1])->row_array();

        // cek jika email nya ada
        if ($user_email) {
            // jika usernya ada bikin token kembali
            $token =  base64_encode(random_bytes(32));
            // siapkan data 
            $user_token = [
                'email' => $email,
                'token' => $token,
                'tgl_buat' => time()
            ];

            // masukkan data
            $this->db->insert('user_token', $user_token);

            // kirim emaik pake fungsi send email
            $this->_kirimEmail($token, 'lupapassword');

            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Silahkan Cek Email Untuk Melakukan Reset Password!!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('auth');
        } else {
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Email Tidak Terdaftar atau Belum Diaktivasi!!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('auth/lupapassword');
        }
    }


    // function untuk reset password
    public function getResetPassword()
    {
        $email =  $this->input->get('email');
        $token = $this->input->get('token');

        // ambil user berdasarkan email di dalam database
        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        // jika ada
        if ($user) {
            // cek tokennya
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            // jika ada
            if ($user_token) {
                // cek waktu tokennya
                if (time() - $user_token['tgl_buat'] < (1440) ) {
                    // jika berhasil buat session agar server aja yang tau, jika reset nya berhasil hapus lagi session
                    $this->session->set_userdata('reset_email' , $email);
                    // jika benar tampilan halaman ubah password
                    $this->ubahpassword();
                } else {
                    $this->session->set_flashdata(
                        'pesan',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Reset Password Gagal, Token Expired!!!</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>'
                    );
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Reset Password Gagal, Token Tidak Valid!!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                );
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Reset Password Gagal, Email Tidak Terdaftar!!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('auth');
        }
    }


    // login
    public function login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // ambil data user
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        // cek usernya jika ada
        if ($user) {
            // jika usernya aktive
            if ($user['active'] == 1) {

                // cek passwordnya
                if (password_verify($password, $user['password'])) {
                    // jika berhasil buat session
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    // buat data ke dalam session
                    $this->session->set_userdata($data);
                    // cek role id
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        # code...
                        redirect('user/profil');
                    }
                } else {
                    // jika gagal
                    $this->session->set_flashdata(
                        'pesan',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Password Salah</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>'
                    );
                    redirect('auth');
                }
            } else {
                // Jika usernya tidak aktif
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Akun Tidak Aktif</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                );
                redirect('auth');
            }
        } else {
            // user tidak ada
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Akun Tidak Terdaftar</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('auth');
        }
    }




    // halaman ubahpassword
    public function ubahpassword()
    {

        // agar tidak bisa di akses tanpa ada token dan email
        if (! $this->session->userdata('reset_email')) {
            
            redirect('auth','refresh');
            
        }

        $this->load->view('auth/ubah-password', FALSE);
    }
}

/* End of file M_auth.php */
