<?php

namespace App\Controllers;

class User extends BaseController
{

    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'        => 'Setting',
            'subtitle'     => 'Manage User',

        ];
        return view('admin/pengaturan/user/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $id = session()->get('id');
            $url = 'user';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            if ($akses == 1) {
                $list =  $this->user->list();
            } elseif ($akses == 2) {
                $list = $this->user->listbyid($id);
            }
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Manage User',
                        'list'      => $list,
                        'akses'     => $akses

                    ];
                    $msg = [
                        'data' => view('admin/pengaturan/user/list', $data)
                    ];
                } else {
                    $msg = [
                        'noakses' => []
                    ];
                }
            } else {

                $msg = [
                    'blmakses' => []
                ];
            }

            echo json_encode($msg);
        }
    }

    public function toggle()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $cari =  $this->user->find($id);

            if ($cari['active'] == '1') {
                $list =  $this->user->getaktif($id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'active'        => $toggle,
                ];
                $this->user->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil nonaktifkan user!'
                ];
            } else {
                $list =  $this->user->getnonaktif($id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'active'        => $toggle,
                ];
                $this->user->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil mengaktifkan user!'
                ];
            }

            echo json_encode($msg);
        }
    }

    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $list =  $this->konfigurasi->orderBy('id_setaplikasi ')->first();
            $konopd = $list['konek_opd'];

            if ($konopd == 1) {
                $opd       = $this->unitkerja->listopd();
            } else {
                $opd       = '';
            }

            $data = [
                'title'       => 'Tambah User',
                'opd'         => $opd,
                'listgrup'   => $this->grupuser->listgrups()
            ];

            $msg = [
                'data' => view('admin/pengaturan/user/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanUser()
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
                        'is_unique' => '{field} tidak boleh sama!',
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'id_grup' => [
                    'label' => 'Grup User',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Silahkan pilih {field}!',
                    ]
                ],

                'foto' => [
                    'label' => 'Foto Profil',
                    'rules' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/png,image/jpg,image/jpeg,image/gif]|is_image[foto]',
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
                        'username'   => $validation->getError('username'),
                        'email'      => $validation->getError('email'),
                        'fullname'   => $validation->getError('fullname'),
                        'password'   => $validation->getError('password'),
                        'foto'       => $validation->getError('foto'),
                        'id_grup'    => $validation->getError('id_grup')
                    ]
                ];
            } else {

                $opd_id  = $this->request->getVar('opd_id');
                $list =  $this->konfigurasi->orderBy('id_setaplikasi ')->first();
                $konopd = $list['konek_opd'];

                if ($konopd == 1) {
                    if ($opd_id != '') {
                        // no unit kerja
                        $filegambar = $this->request->getFile('foto');
                        $nama_file = $filegambar->getRandomName();

                        $insertdata = [

                            'username'       => $this->request->getVar('username'),
                            'email'          => $this->request->getVar('email'),
                            'password_hash'  => (password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)),
                            'fullname'       => $this->request->getVar('fullname'),
                            'user_image'     => $nama_file,
                            'id_grup'          => $this->request->getVar('id_grup'),
                            'active'         => 1,
                            'opd_id'         => $opd_id
                        ];

                        $this->user->insert($insertdata);
                        $filegambar->move('public/img/user/', $nama_file); //folder foto

                        $msg = [
                            'sukses' => 'User berhasil diupload!'
                        ];
                    } else {
                        $msg = [
                            'gopdid' => 'Unit kerja belum dipilih!'
                        ];
                    }
                } else {
                    // no unit kerja
                    $filegambar = $this->request->getFile('foto');
                    $nama_file = $filegambar->getRandomName();

                    $insertdata = [

                        'username'       => $this->request->getVar('username'),
                        'email'          => $this->request->getVar('email'),
                        'password_hash'  => (password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)),
                        'fullname'       => $this->request->getVar('fullname'),
                        'user_image'     => $nama_file,
                        'id_grup'          => $this->request->getVar('id_grup'),
                        'active'         => 1
                    ];

                    $this->user->insert($insertdata);
                    $filegambar->move('public/img/user/', $nama_file); //folder foto

                    $msg = [
                        'sukses' => 'User berhasil ditambahkan!'
                    ];
                }

                // end tanpa unit kerja
            }
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id');
            //check
            $cekdata = $this->user->find($id);
            $fotolama = $cekdata['user_image'];
            if ($fotolama != 'default.png' && file_exists('public/img/user/' . $fotolama)) {
                unlink('public/img/user/' . $fotolama);
            }
            $this->user->delete($id);
            $msg = [
                'sukses' => 'Data User Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->user->find($id[$i]);
                $fotolama = $cekdata['user_image'];
                if ($fotolama != 'default.png' && file_exists('public/img/user/' . $fotolama)) {
                    unlink('public/img/user/' . $fotolama);
                }
                $this->user->delete($id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata Data berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $list =  $this->user->find($id);

            $listset =  $this->konfigurasi->orderBy('id_setaplikasi ')->first();
            // cari setingkan konek opd di seting
            $konopd = $listset['konek_opd'];

            if ($konopd == 1) {
                $opd       = $this->unitkerja->listopd();
            } else {
                $opd       = '';
            }

            $data = [
                'title'      => 'Edit User',
                'id'         => $list['id'],
                'username'   => $list['username'],
                'email'      => $list['email'],
                'fullname'   => $list['fullname'],
                // 'level'      => $list['level'],
                'opd_id'     => $list['opd_id'],
                'opd'        => $opd,
                'id_grup'    => $list['id_grup'],
                'jenisgrp'    => $this->request->getVar('jenisgrp'),
                'listgrup'   => $this->grupuser->listgrups()

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/user/edit', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function updateuser()
    {
        if ($this->request->isAJAX()) {
            $user_id = $this->request->getVar('id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

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
                ],

                'id_grup' => [
                    'label' => 'Grup User',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Silahkan pilih {field}!',
                    ]
                ],


            ]);
            if (!$valid) {
                $msg = [
                    'error' => [

                        'email'   => $validation->getError('email'),
                        'fullname'   => $validation->getError('fullname'),
                        'id_grup'       => $validation->getError('id_grup')
                    ]
                ];
            } else {

                $opd_id  = $this->request->getVar('opd_id');
                $list =  $this->konfigurasi->orderBy('id_setaplikasi ')->first();
                $konopd = $list['konek_opd'];
                if ($konopd == 1) {
                    if ($opd_id != '') {

                        $pass = $this->request->getpost('password');

                        if ($pass != '') {
                            $data = array(
                                'password_hash'  => (password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)),
                            );
                            $this->user->update($user_id, $data);
                        }

                        $updatedata = [
                            'username'       => $this->request->getVar('username'),
                            'email'          => $this->request->getVar('email'),
                            'fullname'       => $this->request->getVar('fullname'),
                            'id_grup'          => $this->request->getVar('id_grup'),
                            'opd_id'         => $opd_id
                        ];


                        $this->user->update($user_id, $updatedata);

                        $msg = [
                            'sukses' => 'User berhasil diubah!'
                        ];
                    } else {
                        $msg = [
                            'gopdid' => 'Unit kerja belum dipilih!'
                        ];
                    }
                } else {

                    $pass = $this->request->getpost('password');

                    if ($pass != '') {
                        $data = array(
                            'password_hash'  => (password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)),
                        );
                        $this->user->update($user_id, $data);
                    }

                    $updatedata = [

                        'username'       => $this->request->getVar('username'),
                        'email'          => $this->request->getVar('email'),
                        'fullname'       => $this->request->getVar('fullname'),
                        'id_grup'        => $this->request->getVar('id_grup'),
                    ];


                    $this->user->update($user_id, $updatedata);

                    $msg = [
                        'sukses' => 'User berhasil diubah!'
                    ];
                }
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
                'username'  => $list['username']

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/user/gantifoto', $data)
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
                $msg = [
                    'sukses' => 'Foto profil berhasil diganti!',
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formlihat()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $list =  $this->user->find($id);

            $listset =  $this->konfigurasi->orderBy('id_setaplikasi ')->first();
            // cari setingkan konek opd di seting
            $konopd = $listset['konek_opd'];

            if ($konopd == 1) {
                $opd       = $this->unitkerja->listopd();
            } else {
                $opd       = '';
            }

            $berita = $this->berita->totberitabyid($id);
            $layanan = $this->layanan->totlayananbyid($id);
            $pengumuman = $this->pengumuman->totpengumumanbyid($id);
            $bank = $this->bankdata->selectCount('bankdata_id')->where('id', $id)->first();
            $foto = $this->foto->selectCount('foto_id')->where('id', $id)->first();
            $video = $this->video->selectCount('video_id')->where('id', $id)->first();

            $data = [
                'title'      => 'Edit User',
                'id'         => $list['id'],
                'username'   => $list['username'],
                'email'      => $list['email'],
                'fullname'   => $list['fullname'],
                'opd_id'     => $list['opd_id'],
                'opd'        => $opd,
                'id_grup'    => $list['id_grup'],
                'jenisgrp'    => $this->request->getVar('jenisgrp'),
                'listgrup'   => $this->grupuser->listgrups(),
                'berita'        => $berita,
                'totlayanan'     => $layanan,
                'totpengumuman' => $pengumuman,
                'bankdata'         => $bank,
                'foto'         => $foto,
                'video'         => $video,
                'ebook'         => $this->ebook->selectCount('ebook_id')->where('id', $id)->first(),

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/user/lihat', $data)
            ];
            echo json_encode($msg);
        }
    }

    // GRUP USER (LEVEL)------------------------------------------------------------

    public function grup()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'        => 'Pengaturan',
            'subtitle'     => 'User Group',

        ];
        return view('admin/pengaturan/user/grup/index', $data);
    }

    public function getgrup()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'user';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            if ($akses == 1) {
                $list =  $this->grupuser->list();
            } elseif ($akses == 2) {
                $list = $this->grupuser->listbyid($id_grup);
            }
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Group User',
                        'list'      =>  $list,
                        'akses'     => $akses
                    ];
                    $msg = [
                        'data' => view('admin/pengaturan/user/grup/list', $data)
                    ];
                } else {
                    $msg = [
                        'noakses' => []
                    ];
                }
            } else {

                $msg = [
                    'blmakses' => []
                ];
            }
            echo json_encode($msg);
        }
    }

    // form add grup
    public function formgrup()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'title'         => 'Tambah Grup',
                'listgrupakses' => $this->modulecms->listmodulgrup(),

            ];
            $msg = [
                'data' => view('admin/pengaturan/user/grup/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpangrup()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_grup' => [
                    'label' => 'Nama Grup',
                    'rules' => 'required|is_unique[cms__usergrup.nama_grup]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_grup' => $validation->getError('nama_grup'),
                    ]
                ];
            } else {

                $akses    = $this->request->getVar('akses');
                $id_modul = $this->request->getVar('id_modul');

                $simpandata = [
                    'nama_grup' => $this->request->getVar('nama_grup'),
                    'ketgrup' => $this->request->getVar('ketgrup'),
                    'jenis' => '2',

                ];

                $this->grupuser->insert($simpandata);

                // detail
                $id_grup = $this->grupuser->getInsertID();

                $jdata = count($id_modul);
                for ($i = 0; $i < $jdata; $i++) {
                    $insertakses = [
                        'id_grup'    => $id_grup,
                        'id_modul'   => $id_modul[$i],
                        'akses'      => $akses[$i],
                    ];

                    $this->grupakses->insert($insertakses);
                }

                $msg = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        }
    }
    // Form Edit hak akses grup
    public function formeditgrup()
    {
        if ($this->request->isAJAX()) {
            $id_grup = $this->request->getVar('id_grup');
            $list =  $this->grupuser->find($id_grup);


            $data = [
                'title'         => 'Edit Group',
                'id_grup'       => $list['id_grup'],
                'nama_grup'     => $list['nama_grup'],
                // 'modul'         => $this->modulecms->list() 
                // 'listgrupakses' => $this->modulecms->listmodulgrup(), listgrupedit
                // 'modul'         => $this->grupakses->listgrupaksesedit($id_grup),
                'modul'         => $this->grupakses->listgrupedit($id_grup),


            ];
            $msg = [
                'sukses' => view('admin/pengaturan/user/grup/edit', $data)
            ];
            echo json_encode($msg);
        }
    }
    // Proses update hak akses grup
    public function updategrup()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_grup' => [
                    'label' => 'Nama Grup',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_grup' => $validation->getError('nama_grup'),
                    ]
                ];
            } else {


                $id_grup = $this->request->getVar('id_grup');

                $akses    = $this->request->getVar('akses');
                $id_modul = $this->request->getVar('id_modul');
                $id_grupakses = $this->request->getVar('id_grupakses');

                $listakses =  $this->grupakses->editaksesmenu($id_grup);

                foreach ($listakses as $key => $value) {
                    $this->grupakses->delete($id_grupakses);
                }

                $jdata = count($id_modul);
                for ($i = 0; $i < $jdata; $i++) {

                    $updatedatadet = [
                        'id_grup'    => $id_grup,
                        'id_modul'   => $id_modul[$i],
                        'akses'      => $akses[$i],
                    ];

                    $this->grupakses->insert($updatedatadet);
                }

                $msg = [
                    'sukses' => 'Hak Akses berhasil diubah',
                ];
            }
            echo json_encode($msg);
        }
    }
    // Form Edit hak akses grup
    public function formlihatakses()
    {
        if ($this->request->isAJAX()) {
            $id_grup = $this->request->getVar('id_grup');
            $list =  $this->grupuser->find($id_grup);

            $data = [
                'title'         => 'Lihat Akses',
                'id_grup'       => $list['id_grup'],
                'nama_grup'     => $list['nama_grup'],
                'modul'         => $this->grupakses->listgrupedit($id_grup),
                // 'modul'         => $this->grupakses->listgrupaksesedit($id_grup),
            ];
            $msg = [
                'sukses' => view('admin/pengaturan/user/grup/lihatakses', $data)
            ];
            echo json_encode($msg);
        }
    }

    // edit nama dan ket saja
    public function formeditgrupnm()
    {
        if ($this->request->isAJAX()) {
            $id_grup = $this->request->getVar('id_grup');
            $list =  $this->grupuser->find($id_grup);

            $data = [
                'title'         => 'Edit Group',
                'id_grup'       => $id_grup,
                'nama_grup'     => $list['nama_grup'],
                'ketgrup'       => $list['ketgrup'],
                // 'modul'         => $this->grupakses->listgrupaksesedit($id_grup),

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/user/grup/editnm', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updategrupnm()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_grup' => [
                    'label' => 'Nama Grup',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_grup' => $validation->getError('nama_grup'),
                    ]
                ];
            } else {
                $updatedata = [
                    'nama_grup' => $this->request->getVar('nama_grup'),
                    'ketgrup' => $this->request->getVar('ketgrup'),
                ];

                $id_grup = $this->request->getVar('id_grup');
                $this->grupuser->update($id_grup, $updatedata);

                $msg = [
                    'sukses' => 'Data berhasil diubah',

                ];
            }
            echo json_encode($msg);
        }
    }

    // ADD AKSES MENU

    public function formaddmenugrup()
    {
        if ($this->request->isAJAX()) {
            $id_grup = $this->request->getVar('id_grup');


            $data = [
                'title'         => 'Tambah Akses Menu',
                'id_grup'       => $id_grup,
                'modul'          => $this->modulecms->listmenuutama()

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/user/grup/addmenu', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpangrupmenu()
    {
        if ($this->request->isAJAX()) {

            $aksesmenu    = $this->request->getVar('aksesmenu');
            $id_modul = $this->request->getVar('id_modul');

            // ubah status menu agar siap ditambahkan di konfigurasi & user
            $id_grup = $this->request->getVar('id_grup');

            $updatedata = [
                'sts_menu' => '1',
            ];

            $id_grup = $this->request->getVar('id_grup');
            $this->grupuser->update($id_grup, $updatedata);

            // Tambahkan ke role grup akses menu
            $jdata = count($id_modul);
            for ($i = 0; $i < $jdata; $i++) {
                $insertakses = [
                    'id_grup'    => $id_grup,
                    'id_modul'   => $id_modul[$i],
                    'aksesmenu'  => $aksesmenu[$i],
                ];

                $this->grupakses->insert($insertakses);
            }
            $msg = [
                'sukses' => 'Data berhasil disimpan'
            ];

            echo json_encode($msg);
        }
    }

    // EDIT MENU ...........

    public function formeditmenugrup()
    {
        if ($this->request->isAJAX()) {
            $id_grup = $this->request->getVar('id_grup');
            $data = [
                'title'         => 'Tambah Akses Menu',
                'id_grup'       => $id_grup,
                'modul'         => $this->grupakses->editaksesmenu($id_grup),

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/user/grup/editmenu', $data)
            ];
            echo json_encode($msg);
        }
    }

    // Proses update hak akses menu grup
    public function updatemenu()
    {
        if ($this->request->isAJAX()) {


            $id_grup = $this->request->getVar('id_grup');

            $aksesmenu    = $this->request->getVar('aksesmenu');
            $id_modul = $this->request->getVar('id_modul');
            $id_grupakses = $this->request->getVar('id_grupakses');

            $listakses =  $this->grupakses->editaksesmenu($id_grup);

            foreach ($listakses as $key => $value) {
                $this->grupakses->delete($id_grupakses);
            }

            $jdata = count($id_modul);
            for ($i = 0; $i < $jdata; $i++) {

                $updatedatadet = [
                    'id_grup'    => $id_grup,
                    'id_modul'   => $id_modul[$i],
                    'aksesmenu'  => $aksesmenu[$i],
                ];

                $this->grupakses->insert($updatedatadet);
            }

            $msg = [
                'sukses' => 'Hak Akses Menu berhasil diubah',
            ];
        }
        echo json_encode($msg);
    }

    public function hapusgrup()
    {
        if ($this->request->isAJAX()) {
            $id_grup = $this->request->getVar('id_grup');

            //   cek dan hapus juga di grup akses
            $cekmodulakses =  $this->grupakses->listaksesgrup($id_grup);
            // GRUPAKSES 
            if ($cekmodulakses) {
                foreach ($cekmodulakses as $data) :
                    $this->grupakses->delete($data['id_grupakses']);
                endforeach;
                # code...
            }

            $this->grupuser->delete($id_grup);

            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }
}
