<?php

namespace App\Controllers;

class Akun extends BaseController
{
    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $userid = session()->get('id');
        $list =  $this->user->find($userid);

        $data = [
            'title'      => 'Update Profile',
            'subtitle'   => $list['fullname'],
            'id'         => $list['id'],
            'username'   => $list['username'],
            'email'      => $list['email'],
            'fullname'   => $list['fullname'],
            'level'      => $list['level'],
            'user_image'  => $list['user_image'],
            'role'       => $this->grupuser->listbyid($list['id_grup']),
        ];
        return view('admin/pengaturan/user/akun/akun', $data);
    }

    public function updateuser()
    {
        if ($this->request->isAJAX()) {
            $user_id = $this->request->getVar('id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
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
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'valid_email' => 'Masukkan {field} dengan benar!',
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'username'      => $validation->getError('username'),
                        'email'      => $validation->getError('email'),
                        'fullname'   => $validation->getError('fullname'),
                    ]
                ];
            } else {

                $pass = $this->request->getpost('password');

                if ($pass != '') {
                    $data = array(
                        'password_hash'  => (password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)),
                    );
                    $this->user->update($user_id, $data);
                }

                $updatedata = [
                    'username'          => $this->request->getVar('username'),
                    'email'          => $this->request->getVar('email'),
                    'fullname'       => $this->request->getVar('fullname'),
                ];

                $this->user->update($user_id, $updatedata);
                $msg = [
                    'sukses' => 'Profil berhasil diubah!'
                ];
            }
            echo json_encode($msg);
        }
    }


    public function formgantifoto()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $list =  $this->user->find($id);
            $data = [
                'title'       => 'Ganti Foto Profil',
                'id'          => $list['id'],
                'user_image'  => $list['user_image'],
                'username'    => $list['username']

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/user/akun/gantifoto', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function douploaduser()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'fotouser' => [
                    'label' => 'Foto Profil',
                    'rules' => 'uploaded[fotouser]|max_size[fotouser,1024]|mime_in[fotouser,image/png,image/jpg,image/jpeg,image/gif]|is_image[fotouser]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar',
                        'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'fotouser' => $validation->getError('fotouser')
                    ]
                ];
            } else {

                //check
                $cekdata = $this->user->find($id);
                $fotolama = $cekdata['user_image'];

                if ($fotolama != 'default.png' && file_exists('public/img/user/' . $fotolama)) {
                    unlink('public/img/user/' . $fotolama);
                }

                $filegambar = $this->request->getFile('fotouser');
                $nama_file = $filegambar->getRandomName();

                $updatedata = [
                    'user_image' => $nama_file
                ];

                $this->user->update($id, $updatedata);
                \Config\Services::image()
                    ->withFile($filegambar)
                    ->fit(215, 220, 'center')
                    ->save('public/img/user/' . $nama_file);

                unset($_SESSION['user_image']);

                $simpan_session = [

                    'user_image'  => $nama_file,
                    'fullname'       => $this->request->getVar('fullname'),
                ];

                $this->session->set($simpan_session);

                $msg = [
                    'sukses' => 'Foto profil berhasil diganti!',
                ];
            }
            echo json_encode($msg);
        }
    }
}
