<?php

namespace App\Controllers;

class Modul extends BaseController
{

    //list frontend
    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $konfigurasi = $this->konfigurasi->vkonfig();

        $data = [
            'title'       => 'Setting Modul ',
            'subtitle'    => $konfigurasi->nama,

        ];

        return view('admin/pengaturan/modul/grupmenu/index', $data);
    }

    public function det($gm = null)
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($gm == '') {
            return redirect()->to(base_url('modul'));
        }

        $data = [
            'title'            => 'Pengaturan',
            'subtitle'         => 'Modul',
            'gm'  => $gm,
        ];
        return view('admin/pengaturan/modul/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'modul';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);
            $gm = $this->request->getVar('gm');
            $list      = $this->modulecms->listbygrupall($gm);

            $modulmenu = $this->modulecms->listmenuutama();

            if ($modulmenu) {
                $pilmodul = $modulmenu;
            } else {
                $pilmodul = '-';
            }

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {

                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'      => 'Modul CMS',
                        'list'       => $list,
                        'akses'      => $akses,
                        'modulmenu'  => $pilmodul
                    ];
                    $msg = [
                        'data' => view('admin/pengaturan/modul/list', $data)
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
        } else {
            return redirect()->to(base_url('admin'));
        }
    }


    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Modul',
                'gm' => $this->request->getVar('gm'),
                // 'modulmenu'     => $this->modulecms->listmenuutama()
            ];
            $msg = [
                'data'          => view('admin/pengaturan/modul/tambah', $data),

            ];
            echo json_encode($msg);
        }
    }

    public function simpanmodul()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'modul' => [
                    'label' => 'Nama Modul',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        // 'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'urlmenu' => [
                    'label' => 'Link URL',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'urut' => [
                    'label' => 'Urutan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'modul'          => $validation->getError('modul'),
                        'urlmenu'        => $validation->getError('urlmenu'),
                        'urut'         => $validation->getError('urut'),
                    ]
                ];
                echo json_encode($msg);
            } else {

                $insertdata = [
                    'modul'          => $this->request->getVar('modul'),
                    'urlmenu'        => $this->request->getVar('urlmenu'),
                    'gm'             => $this->request->getVar('gm'),
                    'urut'           => $this->request->getVar('urut'),
                    'ikonmn'         => $this->request->getVar('ikonmn'),

                    'tipemn'         => 'sm',
                    'level'          => '3',


                ];
                $this->modulecms->insert($insertdata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan!'
                ];
                echo json_encode($msg);
            }
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id_modul');
            $cekmodulakses =  $this->grupakses->listaksesmodul($id);
            // GRUPAKSES 
            if ($cekmodulakses) {
                foreach ($cekmodulakses as $data) :
                    $this->grupakses->delete($data['id_grupakses']);
                endforeach;
                # code...
            }
            $this->modulecms->delete($id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $id_modul = $this->request->getVar('id_modul');
            $list =  $this->modulecms->find($id_modul);

            $data = [
                'title'      => 'Edit Modul',
                'id_modul'   => $list['id_modul'],
                'modul'      => $list['modul'],
                'gm'         => $list['gm'],
                'urlmenu'    => $list['urlmenu'],
                'urut'       => $list['urut'],
                'ikonmn'     => $list['ikonmn'],
                'modulmenu'  => $this->modulecms->listmenuutama()

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/modul/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatemodul()
    {
        if ($this->request->isAJAX()) {
            $id_modul = $this->request->getVar('id_modul');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'modul' => [
                    'label' => 'Nama Modul',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'urlmenu' => [
                    'label' => 'Link URL',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'urut' => [
                    'label' => 'Urutan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'modul'          => $validation->getError('modul'),
                        'urlmenu'        => $validation->getError('urlmenu'),
                        'urut'         => $validation->getError('urut'),
                    ]
                ];
            } else {

                $updatedata = [
                    'modul'          => $this->request->getVar('modul'),
                    'urlmenu'        => $this->request->getVar('urlmenu'),
                    'gm'             => $this->request->getVar('gm'),
                    'urut'           => $this->request->getVar('urut'),
                    'ikonmn'         => $this->request->getVar('ikonmn'),


                ];
                $this->modulecms->update($id_modul, $updatedata);
                $msg = [
                    'sukses' => 'Data berhasil diubah!'
                ];
            }
            echo json_encode($msg);
        }
    }

    // Set akses modul ke Role

    public function formsetakses()
    {
        if ($this->request->isAJAX()) {

            $id_modul = $this->request->getVar('id_modul');
            $list =  $this->modulecms->find($id_modul);
            $jrole = $this->grupuser->selectCount('id_grup')->first();

            // $carigrupakses =  $this->grupakses->find($id_modul);
            $totalmodul     = $this->grupakses->totmodul($id_modul);
            if ($totalmodul == $jrole['id_grup']) {
                $statusnya = 'OK';
            } else {
                $statusnya = 'No Akses';
            }
            $data = [
                'title'         => 'Set Akses Modul',
                'id_modul'      => $list['id_modul'],
                'modul'         => $list['modul'],
                'statusnya'     => $statusnya,
                'modulmenu'     => $this->modulecms->listmenuutama(),
                'listgrup'      => $this->grupuser->list(),

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/modul/setakses', $data)
            ];
            echo json_encode($msg);
        }
    }

    // simpan ke grup akses module baru

    public function simpansetakses()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([

                'id_grup' => [
                    'label' => 'Grup Akses',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'id_grup'    => $validation->getError('id_grup'),
                    ]
                ];
            } else {
                $id_modul = $this->request->getVar('id_modul');
                $id_grup = $this->request->getVar('id_grup');
                $akses = $this->request->getVar('akses');

                $listganda =  $this->grupakses->listgrupaksesganda($id_grup, $id_modul);
                if ($listganda) {

                    $msg = [
                        'aksesganda' => 'Grup Akses sudah ditentukan.'
                    ];
                } else {
                    $insertakses = [
                        'id_grup'    => $id_grup,
                        'id_modul'   => $id_modul,
                        'akses'      => $akses,
                    ];

                    $this->grupakses->insert($insertakses);

                    $msg = [
                        'sukses' => 'Modul berhasil ditambahkan ke Role Grup!'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    public function toggle()
    {
        if ($this->request->isAJAX()) {
            $id_modul = $this->request->getVar('id_modul');
            $cari =  $this->modulecms->find($id_modul);

            if ($cari['aktif'] == '1') {
                $list =  $this->modulecms->getaktif($id_modul);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'aktif'        => $toggle,
                ];

                $this->modulecms->update($id_modul, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil nonaktifkan modul!'
                ];
            } else {
                $list =  $this->modulecms->getnonaktif($id_modul);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'aktif'        => $toggle,
                ];

                $this->modulecms->update($id_modul, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil mengaktifkan Modul!'
                ];
            }

            echo json_encode($msg);
        }
    }

    // GRUP MENU (UTAMA)------------------------------------------------------------

    public function grupmenu()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'        => 'Pengaturan',
            'subtitle'     => 'Modul',
        ];
        return view('admin/pengaturan/modul/grupmenu/index', $data);
    }

    public function getgrupmenu()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'modul';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Menu Grup',
                        'list'      =>  $this->modulecms->listmenuutama(),
                        'akses'     =>  $akses
                        // 'modul'          => $this->modulecms->listmenuutama()
                    ];
                    $msg = [
                        'data' => view('admin/pengaturan/modul/grupmenu/list', $data)
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

    public function formtambahmenu()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Modul',
                'modulmenu'     => $this->modulecms->listmenuutama()
            ];
            $msg = [
                'data'          => view('admin/pengaturan/modul/grupmenu/tambah', $data),

            ];
            echo json_encode($msg);
        }
    }

    public function simpangrupmenu()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'modul' => [
                    'label' => 'Nama Menu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        // 'is_unique' => '{field} tidak boleh sama'
                    ]
                ],

                'urut' => [
                    'label' => 'Urutan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'gm' => [
                    'label' => 'Grup',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'modul'        => $validation->getError('modul'),
                        'urut'         => $validation->getError('urut'),
                        'gm'         => $validation->getError('gm'),
                    ]
                ];
                echo json_encode($msg);
            } else {

                $insertdata = [
                    'modul'      => $this->request->getVar('modul'),
                    'urlmenu'    => '-',
                    'gm'         => $this->request->getVar('gm'),
                    'urut'      => $this->request->getVar('urut'),
                    'ikonmn'    => $this->request->getVar('ikonmn'),
                    'tipemn'    => 'utm',
                    'level'     => '3',


                ];
                $this->modulecms->insert($insertdata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan!'
                ];
                echo json_encode($msg);
            }
        }
    }

    // Set akses modul ke Role

    public function formsetaksesmenu()
    {
        if ($this->request->isAJAX()) {

            $id_modul = $this->request->getVar('id_modul');
            $list =  $this->modulecms->find($id_modul);
            $jrole = $this->grupuser->selectCount('id_grup')->first();

            // $carigrupakses =  $this->grupakses->find($id_modul);
            $totalmodul     = $this->grupakses->totmodul($id_modul);
            if ($totalmodul >= $jrole['id_grup']) {
                $statusnya = 'OK';
            } else {
                $statusnya = 'Belum';
            }
            $data = [
                'title'         => 'Set Akses Menu',
                'id_modul'     => $list['id_modul'],
                'modul'          => $list['modul'],
                'statusnya'       => $statusnya,
                'modulmenu'     => $this->modulecms->listmenuutama(),
                'listgrup'   => $this->grupuser->list(),

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/modul/grupmenu/setakses', $data)
            ];
            echo json_encode($msg);
        }
    }

    // simpan set akses ke grup akses module baru (dalam)

    public function simpansetaksesmenu()
    {
        if ($this->request->isAJAX()) {
            $id_modul = $this->request->getVar('id_modul');
            $id_grup = $this->request->getVar('id_grup');
            $aksesmenu = $this->request->getVar('aksesmenu');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'id_grup' => [
                    'label' => 'Grup Akses',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        // 'is_unique' => '{field} tidak boleh sama'
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'id_grup'    => $validation->getError('id_grup'),

                    ]
                ];
            } else {
                // listgrupaksesganda
                $listganda =  $this->grupakses->listgrupaksesganda($id_grup, $id_modul);
                if ($listganda) {
                    $msg = [
                        'aksesganda' => 'Grup Akses sudah ditentukan.'
                    ];
                } else {

                    $insertakses = [
                        'id_grup'    => $id_grup,
                        'id_modul'   => $id_modul,
                        'aksesmenu'      => $aksesmenu,
                    ];

                    $this->grupakses->insert($insertakses);

                    $msg = [
                        'sukses' => 'Menu berhasil ditambahkan ke Role Grup!'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }
    // edit grup menu
    public function formeditmenu()
    {
        if ($this->request->isAJAX()) {

            $id_modul = $this->request->getVar('id_modul');
            $list =  $this->modulecms->find($id_modul);

            $data = [
                'title'      => 'Edit Menu',
                'id_modul'   => $list['id_modul'],
                'modul'      => $list['modul'],
                'gm'         => $list['gm'],
                // 'urlmenu'    => $list['urlmenu'],
                'urut'       => $list['urut'],
                'ikonmn'     => $list['ikonmn'],
                'modulmenu'  => $this->modulecms->listmenuutama()

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/modul/grupmenu/edit', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function updatemodulmenu()
    {
        if ($this->request->isAJAX()) {
            $id_modul = $this->request->getVar('id_modul');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'modul' => [
                    'label' => 'Nama Modul',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'gm' => [
                    'label' => 'Grup',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'urut' => [
                    'label' => 'Urutan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'modul'          => $validation->getError('modul'),
                        'gm'        => $validation->getError('gm'),
                        'urut'         => $validation->getError('urut'),
                    ]
                ];
            } else {

                $updatedata = [
                    'modul'      => $this->request->getVar('modul'),
                    'gm'         => $this->request->getVar('gm'),
                    'urut'      => $this->request->getVar('urut'),
                    'ikonmn'    => $this->request->getVar('ikonmn'),

                ];
                $this->modulecms->update($id_modul, $updatedata);
                $msg = [
                    'sukses' => 'Data berhasil diubah!'
                ];
            }
            echo json_encode($msg);
        }
    }

    // MODUL UNTUK PUBLIK

    public function publik()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'       => 'Modul',
            'subtitle'    => 'Publik',
        ];
        return view('admin/pengaturan/modul/publik/index', $data);
    }

    public function getpublik()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'modul';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;

            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {

                    $data = [
                        'title'     => 'Modul Publik',
                        'list'      => $this->modulpublic->list(),
                        'akses'     => $akses
                    ];
                    $msg = [
                        'data' => view('admin/pengaturan/modul/publik/list', $data)
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

    public function formpublik()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Modul'
            ];
            $msg = [
                'data' => view('admin/pengaturan/modul/publik/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanpublik()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'modpublic' => [
                    'label' => 'Modul',
                    'rules' => 'required|is_unique[cms__modpublic.modpublic]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ],
                'link' => [
                    'label' => 'Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'modpublic' => $validation->getError('modpublic'),
                        'link' => $validation->getError('link'),
                    ]
                ];
            } else {
                $simpandata = [
                    'modpublic' => $this->request->getVar('modpublic'),
                    'link'      => $this->request->getVar('link'),
                ];

                $this->modulpublic->insert($simpandata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditpublik()
    {
        if ($this->request->isAJAX()) {
            $id_modpublic = $this->request->getVar('id_modpublic');
            $list =  $this->modulpublic->find($id_modpublic);
            $data = [
                'title'          => 'Edit Modul',
                'id_modpublic'   => $list['id_modpublic'],
                'modpublic'      => $list['modpublic'],
                'link'           => $list['link'],
            ];
            $msg = [
                'sukses' => view('admin/pengaturan/modul/publik/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatepublik()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'modpublic' => [
                    'label' => 'Modul',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'link' => [
                    'label' => 'Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'modpublic' => $validation->getError('modpublic'),
                        'link'      => $validation->getError('link'),
                    ]
                ];
            } else {
                $updatedata = [
                    'modpublic' => $this->request->getVar('modpublic'),
                    'link'      => $this->request->getVar('link'),
                ];

                $id_modpublic = $this->request->getVar('id_modpublic');
                $this->modulpublic->update($id_modpublic, $updatedata);

                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapuspublik()
    {
        if ($this->request->isAJAX()) {
            $id_modpublic = $this->request->getVar('id_modpublic');
            $this->modulpublic->delete($id_modpublic);
            $msg = [
                'sukses' => 'Modul Publik Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    //publish dan unpublish modul publik
    public function togglepublik()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_modpublic');
            $cari =  $this->modulpublic->find($id);

            if ($cari['stsmod'] == '1') {
                $list =  $this->modulpublic->getaktif($id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'stsmod'        => $toggle,
                ];
                $this->modulpublic->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil Non Aktifkan!'
                ];
            } else {
                $list =  $this->modulpublic->getnonaktif($id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'stsmod'        => $toggle,
                ];
                $this->modulpublic->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil Mengaktifkan!'
                ];
            }

            echo json_encode($msg);
        }
    }
    // End MODul Publik
}
