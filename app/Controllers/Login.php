<?php

namespace App\Controllers;

use Config\Services;
use App\Models\ModelUser;

class Login extends BaseController
{

    public function __construct()
    {
        $this->session = Services::session();
        $this->db = \Config\Database::connect();
    }


    public function index()
    {
        if (session('login')) {
            return redirect()->to(base_url('dashboard'));
        }
        $konfigurasi        = $this->konfigurasi->vkonfig();
        $data = [
            'title'         => 'Login',
            'konfigurasi'   => $konfigurasi,
            'sitekey'       => $konfigurasi->g_sitekey,
        ];

        $db      = \Config\Database::connect();
        $builder = $db->table('users');

        $offkan = ['sts_on'      => '0'];

        $builder->update($offkan, "sts_on != 'x'");

        return view('auth/v_login_user', $data);
    }


    public function validasi()
    {
        if ($this->request->isAJAX()) {
            $username = $this->request->getVar('username');
            $password_hash = $this->request->getVar('password_hash');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi!'
                    ]
                ],
                'password_hash' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi!'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'username' => $validation->getError('username'),
                        'password_hash' => $validation->getError('password_hash')
                    ]
                ];
            } else {
                $user = $this->user->where('username', $username)->first();

                if ($user) {

                    $password_user = $user['password_hash'];
                    if (password_verify($password_hash, $password_user)) {

                        if ($user['active'] == 1) {

                            $konfigurasi        = $this->konfigurasi->vkonfig();
                            $secretkey = $konfigurasi->g_secretkey;
                            $g_sitekey = $konfigurasi->g_sitekey;

                            // gcaptcha
                            $secret = $secretkey;
                            if ($secretkey != '' && $g_sitekey != '') {
                                $recaptchaResponse = trim($this->request->getVar('g-recaptcha-response'));
                                $credential = array(
                                    'secret' => $secret,
                                    'response' => $recaptchaResponse
                                );

                                $verify = curl_init();
                                curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
                                curl_setopt($verify, CURLOPT_POST, true);
                                curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
                                curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
                                $response = curl_exec($verify);

                                $status = json_decode($response, true);
                                $credential = array(
                                    'secret' => $secret,
                                    'response' => $recaptchaResponse
                                );

                                $status = json_decode($response, true);
                                if ($status['success']) {
                                    $simpan_session = [
                                        'login'         => true,
                                        'id'            => $user['id'],
                                        'username'      => $username,
                                        'fullname'      => $user['fullname'],
                                        'user_image'    => $user['user_image'],
                                        'id_grup'       => $user['id_grup'],
                                        'setweb'        => 'https://cms.datagoe.com/',
                                    ];

                                    // Update login
                                    $data = [
                                        'last_login'  => date('Y-m-d H:i:s'),
                                        'sts_on'      => '1',
                                        'login_attempts' => 0
                                    ];

                                    $this->user->update($user['id'], $data);
                                    $this->session->set($simpan_session);

                                    $msg = [
                                        'sukses' => []
                                    ];
                                } else {
                                    $this->user->update($user['id'], [
                                        'login_attempts' => $user['login_attempts'] + 1
                                    ]);

                                    if ($user['login_attempts'] >= 3) {
                                    } else {
                                        $msg = [
                                            'usahalebih' => 'Terlalu banyak upaya login. Coba lagi nanti!'
                                        ];
                                    }
                                    $msg = [
                                        'gagalcap' => 'Gagal Login Silahkan periksa Kembali!'
                                    ];
                                }
                            } else {
                                // normal tanpa capthca
                                $simpan_session = [
                                    'login'         => true,
                                    'id'            => $user['id'],
                                    'username'      => $username,
                                    'fullname'      => $user['fullname'],
                                    'user_image'    => $user['user_image'],
                                    'id_grup'       => $user['id_grup'],
                                    'setweb'        => 'https://cms.datagoe.com/',
                                ];

                                $data = [
                                    'last_login'  => date('Y-m-d H:i:s'),
                                    'sts_on'      => '1',
                                    'login_attempts' => 0
                                ];

                                $this->user->update($user['id'], $data);
                                $this->session->set($simpan_session);

                                $msg = [
                                    'sukses' => []
                                ];
                                // end normal no captcha
                            }
                        } else {
                            $this->user->update($user['id'], [
                                'login_attempts' => $user['login_attempts'] + 1
                            ]);
                            $msg = [
                                'nonactive' => [
                                    'nonactive' => 'Status akun anda tidak aktif, silakan hubungi admin!'
                                ]
                            ];
                        }
                    } else {
                        $this->user->update($user['id'], [
                            'login_attempts' => $user['login_attempts'] + 1
                        ]);
                        if ($user['login_attempts'] >= 3) {
                            $msg = [
                                'usahalebih' => 'Terlalu banyak upaya login. Coba lagi nanti!'
                            ];
                        } else {
                            $msg = [
                                'error' => [
                                    'password_hash' => 'User atau password yang anda masukkan salah!'
                                ]
                            ];
                        }
                    }
                } else {
                    $msg = [
                        'error' => [
                            'username' => 'User atau password yang anda masukkan salah!'
                        ]
                    ];
                }
            }

            echo json_encode($msg);
        }
    }


    public function logout()
    {

        if ($this->request->isAJAX()) {


            $id      = session()->get('id');
            $offkan = ['sts_on'      => '0'];
            $this->user->update($id, $offkan);
            $this->session->destroy();

            $data = [
                'respond'   => 'success',
                'message'   => 'Anda berhasil Keluar..!'
            ];

            echo json_encode($data);
        }
    }

    // FORGOT
    public function lupapassword()
    {
        if (session('login')) {

            return redirect()->to(base_url('dashboard'));
        }
        $data = [
            'title' => 'Lupa Password'
        ];
        return view('auth/v_forgot', $data);
    }


    public function proseslupa()
    {

        if ($this->request->isAJAX()) {
            $email = $this->request->getVar('email');
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'valid_email' => 'Masukkan {field} dengan benar!',

                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'email' => $validation->getError('email'),
                    ]
                ];
            } else {

                //cek user

                $user = $this->user->where('email', $email)->first();

                if ($user) {

                    $user_id = $user['id'];

                    if ($user['email'] == $email) {


                        if (!empty($user['reset_expires']) && $user['reset_expires'] >= time()) {

                            $msg = [
                                'resetexpair' => []
                            ];
                        } else {

                            helper('text');
                            $reshas = (random_string('alnum', 32));
                            $updatedata = [
                                'reset_hash'       => $reshas,
                                'reset_expires'    => time() + HOUR,
                            ];

                            $this->user->update($user_id, $updatedata);

                            $balas = base_url('resetpassword?token=' .  $reshas); //isi balasan 
                            $title = 'Reset Password Login'; //Judul
                            $pesanbalas = '<h2> Silahkan klik link dibawah untuk mengganti password..! </h2>
                            <p>
                            <a href=' . $balas . ' target=_blank </a>
                            <h3> ' . $balas . ' </h3>
                            </p> 
                            <hr>
                            <p><h4>Jika bukan anda yang lakukan permintaan, Abaikan pesan ini.</h4></p>';

                            $this->sendEmail($email, $title, $pesanbalas);

                            $msg = [
                                'sukses' => []
                            ];
                        }
                    } else {
                        $msg = [
                            'error' => [
                                'password_hash' => 'Password salah!'
                            ]
                        ];
                    }
                } else {
                    $msg = [
                        'wrongemail' => [
                            'wrongemail' => 'Email tidak ditemukan!'
                        ]
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    private function sendEmail($emailusr, $title, $pesanbalas)
    {
        $email_smtp = \Config\Services::email();
        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();

        $namadinas = $konfigurasi['smtp_pengirim']; //nama samar
        $namadomain = $konfigurasi['smtp_host'];
        $smptuser = $konfigurasi['smtp_username'];
        $pass = $konfigurasi['smtp_password'];
        $port = $konfigurasi['smtp_port'];

        $config["protocol"] = "smtp";

        //isi sesuai nama domain/mail server
        $config["SMTPHost"]  = $namadomain;

        //alamat email SMTP
        $config["SMTPUser"]  = $smptuser;

        //password email SMTP
        $config["SMTPPass"]  = $pass;

        $config["SMTPPort"]  = $port;
        $config["SMTPCrypto"] = "ssl";

        $email_smtp->initialize($config);

        $email_smtp->setFrom($smptuser, $namadinas);
        $email_smtp->setTo($emailusr);
        $email_smtp->setSubject($title);
        $email_smtp->setMessage($pesanbalas);

        $email_smtp->send();
    }

    public function resetpassword()
    {

        $users = new ModelUser();
        $token = $this->request->getGet('token');

        $user = $users->where('reset_hash', $token)
            ->where('reset_expires >', time())
            ->first();

        if (!$user) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'token' => $token
        ];
        return view('auth/v_reset', $data);
    }


    public function prosesgantipass()
    {

        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([

                'password' => [
                    'label' => 'password',
                    'rules' => 'required|min_length[5]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'min_length' => '{field} minimal 5 karakter!',

                    ]
                ],
                'password_confirm' => [
                    'label' => 'Password',
                    'rules' => 'matches[password]',
                    'errors' => [
                        'matches' => '{field} tidak sama!',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'password' => $validation->getError('password'),
                        'password_confirm' => $validation->getError('password_confirm'),
                    ]
                ];
            } else {

                $users = new ModelUser();

                $user = $users->where('reset_hash', $this->request->getVar('token'))
                    ->where('reset_expires >', time())
                    ->first();
                //cek user

                if (!$user) {
                    return redirect()->to(base_url('login'));
                } else {

                    $user_id = $user['id'];

                    $updatedata = [
                        'reset_hash'       => null,
                        'reset_expires'    => null,
                        'password_hash'  => (password_hash($this->request->getVar('password_confirm'), PASSWORD_BCRYPT)),
                    ];

                    $this->user->update($user_id, $updatedata);
                    $msg = [
                        'sukses' => []
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    // Registrasi
    public function registrasi()
    {
        // $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
        $konfigurasi        = $this->konfigurasi->vkonfig();
        $sts = $konfigurasi->sts_regis;
        $konopd = $konfigurasi->konek_opd;

        if ($konopd == 1) {
            $opd       = $this->unitkerja->listopd();
        } else {
            $opd       = '';
        }

        if (session('login')) {

            return redirect()->to(base_url('dashboard'));
        }

        if ($sts == 0) {

            return redirect()->to(base_url('/'));
        }

        $data = [
            'title'         => 'Registrasi Pengguna',
            'opd'            => $opd,
            'konfigurasi'   => $konfigurasi,
            'sitekey'       => $konfigurasi->g_sitekey,

        ];
        return view('auth/v_registrasi', $data);
    }


    public function daftarakun()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|is_unique[users.username]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_unique' => '{field} tidak boleh sama!',
                    ]
                ],
                'fullname' => [
                    'label' => 'Nama Lengkap',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email|is_unique[users.email]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'valid_email' => 'Masukkan {field} dengan benar!',
                        'is_unique' => '{field} sudah terdaftar, Silahkan ganti..!',
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'password_confirm' => [
                    'label' => 'Password',
                    'rules' => 'matches[password]',
                    'errors' => [
                        'matches' => '{field} tidak sama!',
                    ]
                ],

                'user_image' => [
                    'label' => 'Foto Profil',
                    'rules' => 'max_size[user_image,1024]|mime_in[user_image,image/png,image/jpg,image/jpeg,image/gif]|is_image[user_image]',
                    'errors' => [
                        // 'uploaded' => 'Silahkan Masukkan user_image',
                        'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
                        'mime_in'  => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'username'   => $validation->getError('username'),
                        'fullname'   => $validation->getError('fullname'),
                        'email'   => $validation->getError('email'),
                        'password'   => $validation->getError('password'),
                        'password_confirm' => $validation->getError('password_confirm'),
                        'user_image'       => $validation->getError('user_image'),
                    ]
                ];
            } else {
                $opd_id  = $this->request->getVar('opd_id');
                $list =  $this->konfigurasi->orderBy('id_setaplikasi ')->first();
                $konopd = $list['konek_opd'];
                $id_grup = $list['id_grup'];
                $secretkey = $list['g_secretkey'];
                $g_sitekey = $list['g_sitekey'];


                $secret = $secretkey;
                if ($konopd == 1) {
                    if ($opd_id != '') {

                        // with unit kerja
                        $filegambar = $this->request->getFile('user_image');
                        $nama_file = $filegambar->getRandomName();
                        //jika gambar tidak ada
                        if ($filegambar->GetError() == 4) {
                            if ($secretkey != '' && $g_sitekey != '') {
                                // gcaptcha
                                $recaptchaResponse = trim($this->request->getVar('g-recaptcha-response'));

                                $credential = array(
                                    'secret' => $secret,
                                    'response' => $recaptchaResponse
                                );

                                $verify = curl_init();
                                curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
                                curl_setopt($verify, CURLOPT_POST, true);
                                curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
                                curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
                                $response = curl_exec($verify);

                                $status = json_decode($response, true);

                                if ($status['success']) {

                                    $insertdata = [
                                        'username'       => $this->request->getVar('username'),
                                        'email'          => $this->request->getVar('email'),
                                        'password_hash'  => (password_hash($this->request->getVar('password_confirm'), PASSWORD_BCRYPT)),
                                        'fullname'       => $this->request->getVar('fullname'),
                                        'user_image'     => 'default.png',
                                        'opd_id'         => $opd_id,
                                        'id_grup'        => $id_grup,
                                        'active'         => '0',

                                    ];

                                    $this->user->insert($insertdata);
                                    $msg = [
                                        'sukses' => 'Berhasil registrasi Akun pengguna!'
                                    ];
                                } else {
                                    $msg = [
                                        'gagalcap' => 'Gagal Daftar Silahkan periksa Kembali!'
                                    ];
                                }
                                // end no image with captcha

                            } else {
                                // no captcha
                                $insertdata = [
                                    'username'       => $this->request->getVar('username'),
                                    'email'          => $this->request->getVar('email'),
                                    'password_hash'  => (password_hash($this->request->getVar('password_confirm'), PASSWORD_BCRYPT)),
                                    'fullname'       => $this->request->getVar('fullname'),
                                    'user_image'     => 'default.png',
                                    'opd_id'         => $opd_id,
                                    'id_grup'        => $id_grup,
                                    'active'         => '0',

                                ];

                                $this->user->insert($insertdata);
                                $msg = [
                                    'sukses' => 'Berhasil registrasi Akun pengguna!'
                                ];
                            }
                        } else {
                            // with image
                            if ($secretkey != '' && $g_sitekey != '') {
                                $recaptchaResponse = trim($this->request->getVar('g-recaptcha-response'));

                                $credential = array(
                                    'secret' => $secret,
                                    'response' => $recaptchaResponse
                                );

                                $verify = curl_init();
                                curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
                                curl_setopt($verify, CURLOPT_POST, true);
                                curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
                                curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
                                $response = curl_exec($verify);

                                $status = json_decode($response, true);

                                if ($status['success']) {
                                    $insertdata = [

                                        'username'       => $this->request->getVar('username'),
                                        'email'          => $this->request->getVar('email'),
                                        'password_hash'  => (password_hash($this->request->getVar('password_confirm'), PASSWORD_BCRYPT)),
                                        'fullname'       => $this->request->getVar('fullname'),
                                        'user_image'     => $nama_file,
                                        'opd_id'         => $opd_id,
                                        'id_grup'        => $id_grup,
                                        'active'          => '0',
                                    ];

                                    $this->user->insert($insertdata);
                                    $filegambar->move('public/img/user/', $nama_file); //folder foto

                                    $msg = [
                                        'sukses' => 'Berhasil registrasi Akun pengguna!'
                                    ];
                                } else {
                                    $msg = [
                                        'gagalcap' => 'Gagal Daftar Silahkan periksa Kembali!'
                                    ];
                                }
                                // end with image dan captca
                            } else {
                                // no captca with image
                                $insertdata = [

                                    'username'       => $this->request->getVar('username'),
                                    'email'          => $this->request->getVar('email'),
                                    'password_hash'  => (password_hash($this->request->getVar('password_confirm'), PASSWORD_BCRYPT)),
                                    'fullname'       => $this->request->getVar('fullname'),
                                    'user_image'     => $nama_file,
                                    'opd_id'         => $opd_id,
                                    'id_grup'        => $id_grup,
                                    'active'          => '0',
                                ];

                                $this->user->insert($insertdata);
                                $filegambar->move('public/img/user/', $nama_file); //folder foto

                                $msg = [
                                    'sukses' => 'Berhasil registrasi Akun pengguna!'
                                ];
                            }
                        }
                    } else {
                        $msg = [
                            'gopdid' => 'Unit kerja belum dipilih!'
                        ];
                    }
                } else {

                    //  no unit kerja

                    $filegambar = $this->request->getFile('user_image');
                    $nama_file = $filegambar->getRandomName();
                    //jika gambar tidak ada
                    if ($filegambar->GetError() == 4) {
                        if ($secretkey != '' && $g_sitekey != '') {
                            $recaptchaResponse = trim($this->request->getVar('g-recaptcha-response'));

                            $credential = array(
                                'secret' => $secret,
                                'response' => $recaptchaResponse
                            );

                            $verify = curl_init();
                            curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
                            curl_setopt($verify, CURLOPT_POST, true);
                            curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
                            curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
                            $response = curl_exec($verify);

                            $status = json_decode($response, true);

                            if ($status['success']) {
                                $insertdata = [
                                    'username'       => $this->request->getVar('username'),
                                    'email'          => $this->request->getVar('email'),
                                    'password_hash'  => (password_hash($this->request->getVar('password_confirm'), PASSWORD_BCRYPT)),
                                    'fullname'       => $this->request->getVar('fullname'),
                                    'user_image'     => 'default.png',
                                    'id_grup'        => $id_grup,
                                    'active'          => '0',

                                ];

                                $this->user->insert($insertdata);
                                $msg = [
                                    'sukses' => 'Berhasil registrasi Akun pengguna!'
                                ];
                            } else {
                                $msg = [
                                    'gagalcap' => 'Gagal Daftar Silahkan periksa Kembali!'
                                ];
                            }
                            // end no image with captca

                        } else {
                            // no image no captca
                            $insertdata = [
                                'username'       => $this->request->getVar('username'),
                                'email'          => $this->request->getVar('email'),
                                'password_hash'  => (password_hash($this->request->getVar('password_confirm'), PASSWORD_BCRYPT)),
                                'fullname'       => $this->request->getVar('fullname'),
                                'user_image'     => 'default.png',
                                'id_grup'        => $id_grup,
                                'active'          => '0',

                            ];

                            $this->user->insert($insertdata);
                            $msg = [
                                'sukses' => 'Berhasil registrasi Akun pengguna!'
                            ];
                        }
                    } else {
                        // with image
                        if ($secretkey != '' && $g_sitekey != '') {
                            $recaptchaResponse = trim($this->request->getVar('g-recaptcha-response'));

                            $credential = array(
                                'secret' => $secret,
                                'response' => $recaptchaResponse
                            );

                            $verify = curl_init();
                            curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
                            curl_setopt($verify, CURLOPT_POST, true);
                            curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
                            curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
                            $response = curl_exec($verify);

                            $status = json_decode($response, true);

                            if ($status['success']) {
                                $insertdata = [

                                    'username'       => $this->request->getVar('username'),
                                    'email'          => $this->request->getVar('email'),
                                    'password_hash'  => (password_hash($this->request->getVar('password_confirm'), PASSWORD_BCRYPT)),
                                    'fullname'       => $this->request->getVar('fullname'),
                                    'user_image'     => $nama_file,
                                    'id_grup'        => $id_grup,
                                    'active'          => '0',
                                ];

                                $this->user->insert($insertdata);
                                $filegambar->move('public/img/user/', $nama_file); //folder foto

                                $msg = [
                                    'sukses' => 'Berhasil registrasi Akun pengguna!'
                                ];
                            } else {
                                $msg = [
                                    'gagalcap' => 'Gagal Daftar Silahkan periksa Kembali!'
                                ];
                            }
                            // end with image with captca

                        } else {
                            // no captca
                            $insertdata = [

                                'username'       => $this->request->getVar('username'),
                                'email'          => $this->request->getVar('email'),
                                'password_hash'  => (password_hash($this->request->getVar('password_confirm'), PASSWORD_BCRYPT)),
                                'fullname'       => $this->request->getVar('fullname'),
                                'user_image'     => $nama_file,
                                'id_grup'        => $id_grup,
                                'active'          => '0',
                            ];

                            $this->user->insert($insertdata);
                            $filegambar->move('public/img/user/', $nama_file); //folder foto

                            $msg = [
                                'sukses' => 'Berhasil registrasi Akun pengguna!'
                            ];
                        }
                    }
                }
            }
            echo json_encode($msg);
        }
    }
}
