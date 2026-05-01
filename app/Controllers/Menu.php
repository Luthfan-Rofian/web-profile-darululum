<?php

namespace App\Controllers;

class Menu extends BaseController
{

    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'         => 'Setting',
            'subtitle'      => 'Menu',
        ];
        return view('admin/pengaturan/menu/index', $data);
    }

    public function getmenu()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'menu';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);
            $posisi = $this->request->getVar('posisimn');
            $list      = $this->menu->listutama($posisi);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Setting - Menu',
                        'list'      => $list,
                        'akses'     => $akses
                    ];
                    $msg = [
                        'data' => view('admin/pengaturan/menu/list', $data)
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

    // add menu
    public function formmenu()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title'             => 'Tambah Menu',
                'kategoriberita'    => $this->kategori->list(),
                'halaman'           => $this->berita->listhalaman(),
                'modulpublic'       => $this->modulpublic->listaktif(),
            ];
            $msg = [
                'data' => view('admin/pengaturan/menu/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanmenu()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_menu' => [
                    'label' => 'Nama Menu',
                    'rules' => 'required|is_unique[menu.nama_menu]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ],
                'menu_link' => [
                    'label' => 'Menu Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'urutan' => [
                    'label' => 'Uratan Menu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]


            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_menu' => $validation->getError('nama_menu'),
                        'menu_link' => $validation->getError('menu_link'),
                        'urutan'    => $validation->getError('urutan'),
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_menu'     => $this->request->getVar('nama_menu'),
                    'menu_link'     => $this->request->getVar('menu_link'),
                    'parent'        => $this->request->getVar('parent'),
                    'icon'          => $this->request->getVar('icon'),
                    'urutan'        => $this->request->getVar('urutan'),
                    'target'        => $this->request->getVar('target'),
                    'linkexternal'  => $this->request->getVar('linkexternal')

                ];

                $this->menu->insert($simpandata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditmenu()
    {
        if ($this->request->isAJAX()) {
            $menu_id = $this->request->getVar('menu_id');
            $list =  $this->menu->find($menu_id);
            $data = [
                'title'             => 'Edit Menu',
                'menu_id'           => $list['menu_id'],
                'nama_menu'         => $list['nama_menu'],
                'menu_link'         => $list['menu_link'],
                'parent'            => $list['parent'],
                'icon'              => $list['icon'],
                'urutan'            => $list['urutan'],
                'target'            => $list['target'],
                'linkexternal'      => $list['linkexternal'],
                'kategoriberita'    => $this->kategori->list(),
                'halaman'           => $this->berita->listhalaman(),
                'modulpublic'       => $this->modulpublic->listaktif(),

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/menu/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatemenu()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_menu' => [
                    'label' => 'Nama Menu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'menu_link' => [
                    'label' => 'Menu Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'urutan' => [
                    'label' => 'Uratan Menu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_menu' => $validation->getError('nama_menu'),
                        'menu_link' => $validation->getError('menu_link'),
                        'urutan'    => $validation->getError('urutan'),
                    ]
                ];
            } else {
                $updatedata = [

                    'nama_menu'     => $this->request->getVar('nama_menu'),
                    'menu_link'     => $this->request->getVar('menu_link'),
                    'parent'        => $this->request->getVar('parent'),
                    'icon'          => $this->request->getVar('icon'),
                    'urutan'        => $this->request->getVar('urutan'),
                    'target'        => $this->request->getVar('target'),
                    'linkexternal'  => $this->request->getVar('linkexternal')

                ];

                $menu_id = $this->request->getVar('menu_id');
                $this->menu->update($menu_id, $updatedata);
                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapusmenu()
    {
        if ($this->request->isAJAX()) {

            $menu_id = $this->request->getVar('menu_id');

            $this->menu->delete($menu_id);
            $msg = [
                'sukses' => 'Menu Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    //publish dan unpublish menu
    public function toggle()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('menu_id');
            $cari =  $this->menu->find($id);

            if ($cari['stsmenu'] == '1') {
                $list =  $this->menu->getaktif($id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'stsmenu'        => $toggle,
                ];
                $this->menu->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil Non Aktifkan!'
                ];
            } else {
                $list =  $this->menu->getnonaktif($id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'stsmenu'        => $toggle,
                ];
                $this->menu->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil Mengaktifkan!'
                ];
            }

            echo json_encode($msg);
        }
    }

    // start secodary menu add
    public function formmenusec()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title'             => 'Tambah Menu Secondary',
                'kategoriberita'    => $this->kategori->list(),
                'halaman'           => $this->berita->listhalaman(),
                'modulpublic'       => $this->modulpublic->listaktif(),

            ];
            $msg = [
                'data' => view('admin/pengaturan/menu/tambahsec', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function formeditmenusec()
    {
        if ($this->request->isAJAX()) {
            $menu_id = $this->request->getVar('menu_id');
            $list =  $this->menu->find($menu_id);
            $data = [
                'title'             => 'Edit Secondary Menu',
                'menu_id'           => $list['menu_id'],
                'nama_menu'         => $list['nama_menu'],
                'menu_link'         => $list['menu_link'],
                'parent'            => $list['parent'],
                'icon'              => $list['icon'],
                'urutan'            => $list['urutan'],
                'target'            => $list['target'],
                'linkexternal'      => $list['linkexternal'],
                'posisi'            => $list['posisi'],
                'kategoriberita'    => $this->kategori->list(),
                'halaman'           => $this->berita->listhalaman(),
                'modulpublic'       => $this->modulpublic->listaktif(),

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/menu/editsec', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanmenusec()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_menu' => [
                    'label' => 'Nama Menu',
                    'rules' => 'required|is_unique[menu.nama_menu]',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ],
                'menu_link' => [
                    'label' => 'Menu Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'urutan' => [
                    'label' => 'Uratan Menu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_menu' => $validation->getError('nama_menu'),
                        'menu_link' => $validation->getError('menu_link'),
                        'urutan'    => $validation->getError('urutan'),
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_menu'     => $this->request->getVar('nama_menu'),
                    'menu_link'     => $this->request->getVar('menu_link'),
                    'parent'        => 'N',
                    'icon'          => $this->request->getVar('icon'),
                    'urutan'        => $this->request->getVar('urutan'),
                    'target'        => $this->request->getVar('target'),
                    'posisi'        => $this->request->getVar('posisi'),
                    'linkexternal'  => $this->request->getVar('linkexternal'),


                ];

                $this->menu->insert($simpandata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function updatemenusec()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_menu' => [
                    'label' => 'Nama Menu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'menu_link' => [
                    'label' => 'Menu Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'urutan' => [
                    'label' => 'Uratan Menu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_menu' => $validation->getError('nama_menu'),
                        'menu_link' => $validation->getError('menu_link'),
                        'urutan'    => $validation->getError('urutan'),
                    ]
                ];
            } else {
                $updatedata = [

                    'nama_menu'     => $this->request->getVar('nama_menu'),
                    'menu_link'     => $this->request->getVar('menu_link'),
                    'parent'        => $this->request->getVar('parent'),
                    'icon'          => $this->request->getVar('icon'),
                    'urutan'        => $this->request->getVar('urutan'),
                    'target'        => $this->request->getVar('target'),
                    'linkexternal'  => $this->request->getVar('linkexternal'),
                    'posisi'        => $this->request->getVar('posisi'),


                ];

                $menu_id = $this->request->getVar('menu_id');
                $this->menu->update($menu_id, $updatedata);
                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    // end second
    //Start SUB MENU (backend)
    public function submenu($menu_id = null)
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($menu_id == '') {
            return redirect()->to(base_url('menu'));
        }
        $list      =  $this->submenu->listbyutm($menu_id);
        if ($list) {
            foreach ($list as $data) :
                $menuinduk = $data['nama_menu'];
            endforeach;
        } else {
            $menuinduk = '';
        }

        $data = [
            'title'          => 'Pengaturan',
            'subtitle'       => 'Menu',
            'menu_id'        => $menu_id,
            'menuinduk'      => $menuinduk,

        ];
        return view('admin/pengaturan/menu/submenu/index', $data);
    }

    // get data
    public function getsubmenu()
    {
        if ($this->request->isAJAX()) {
            $menu_id = $this->request->getVar('menu_id');
            $id_grup = session()->get('id_grup');
            $url = 'menu';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Setting - Sub Menu',
                        'list'      =>  $this->submenu->listbyutm($menu_id),
                        'akses'     => $akses

                    ];
                    $msg = [
                        'data' => view('admin/pengaturan/menu/submenu/list', $data)
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

    // ADD sub menu
    public function formsubmenu()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title'             => 'Tambah Sub Menu',
                'menu_id'           => $this->request->getVar('menu_id'),
                'modulpublic'       => $this->modulpublic->listaktif(),
                'kategoriberita'    => $this->kategori->list(),
                'halaman'           => $this->berita->listhalaman(),
            ];
            $msg = [
                'data' => view('admin/pengaturan/menu/submenu/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpansubmenu()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_submenu' => [
                    'label' => 'Nama Sub Menu',
                    'rules' => 'required|is_unique[submenu.nama_submenu]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ],
                'menu_id' => [
                    'label' => 'Menu Induk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],

                'link_submenu' => [
                    'label' => 'Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],

                'urutansm' => [
                    'label' => 'Uratan Sub Menu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_submenu' => $validation->getError('nama_submenu'),
                        'menu_id' => $validation->getError('menu_id'),
                        'link_submenu' => $validation->getError('link_submenu'),
                        'urutansm' => $validation->getError('urutansm'),
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_submenu' => $this->request->getVar('nama_submenu'),
                    'menu_id' => $this->request->getVar('menu_id'),
                    'link_submenu' => $this->request->getVar('link_submenu'),
                    'iconsm' => $this->request->getVar('iconsm'),
                    'urutansm' => $this->request->getVar('urutansm'),
                    'targetsm' => $this->request->getVar('targetsm'),
                    'linkexternalsm' => $this->request->getVar('linkexternalsm'),
                    'parentsm' => $this->request->getVar('parentsm')

                ];

                $this->submenu->insert($simpandata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditsubmenu()
    {
        if ($this->request->isAJAX()) {
            $submenu_id = $this->request->getVar('submenu_id');
            $list =  $this->submenu->find($submenu_id);
            $data = [
                'title'          => 'Edit Sub Menu',
                'submenu_id'     => $list['submenu_id'],
                'menu_id'        => $list['menu_id'],
                'nama_submenu'   => $list['nama_submenu'],
                'link_submenu'   => $list['link_submenu'],
                'iconsm'          => $list['iconsm'],
                'urutansm'        => $list['urutansm'],
                'targetsm'        => $list['targetsm'],
                'linkexternalsm'  => $list['linkexternalsm'],
                'parentsm'        => $list['parentsm'],
                'kategoriberita'    => $this->kategori->list(),
                'halaman'           => $this->berita->listhalaman(),
                'modulpublic'       => $this->modulpublic->listaktif(),

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/menu/submenu/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatesubmenu()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_submenu' => [
                    'label' => 'Nama Sub Menu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'link_submenu' => [
                    'label' => 'Menu Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'urutansm' => [
                    'label' => 'Uratan Sub Menu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_submenu' => $validation->getError('nama_submenu'),
                        'link_submenu' => $validation->getError('link_submenu'),
                        'urutansm' => $validation->getError('urutansm'),
                    ]
                ];
            } else {
                $updatedata = [

                    'nama_submenu' => $this->request->getVar('nama_submenu'),
                    'link_submenu' => $this->request->getVar('link_submenu'),
                    // 'menu_id' => $this->request->getVar('menu_id'),
                    'iconsm' => $this->request->getVar('iconsm'),
                    'urutansm' => $this->request->getVar('urutansm'),
                    'linkexternalsm' => $this->request->getVar('linkexternalsm'),
                    'targetsm' => $this->request->getVar('targetsm'),
                    'parentsm' => $this->request->getVar('parentsm')

                ];

                $submenu_id = $this->request->getVar('submenu_id');
                $this->submenu->update($submenu_id, $updatedata);
                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapussubmenu()
    {
        if ($this->request->isAJAX()) {

            $submenu_id = $this->request->getVar('submenu_id');

            $this->submenu->delete($submenu_id);
            $msg = [
                'sukses' => 'Menu Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    //publish dan unpublish sub menu
    public function togglesub()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('submenu_id');
            $cari =  $this->submenu->find($id);

            if ($cari['stssubmenu'] == '1') {
                $list =  $this->submenu->getaktif($id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'stssubmenu'        => $toggle,
                ];
                $this->submenu->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil Non Aktifkan!'
                ];
            } else {
                $list =  $this->submenu->getnonaktif($id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'stssubmenu'        => $toggle,
                ];
                $this->submenu->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil Mengaktifkan!'
                ];
            }

            echo json_encode($msg);
        }
    }

    // START SUB-SUB MENU

    public function subsubmenu($submenu_id = null)
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($submenu_id == '') {
            return redirect()->to(base_url('menu'));
        }
        $list      =  $this->subsubmenu->listbysub($submenu_id);
        if ($list) {
            foreach ($list as $data) :
                $submenu = $data['nama_submenu'];
            endforeach;
        } else {
            $submenu = '';
        }

        $data = [
            'title'          => 'Pengaturan',
            'subtitle'       => 'Menu Level 3',
            'submenu_id'        => $submenu_id,
            'submenu'        => $submenu,

        ];
        return view('admin/pengaturan/menu/subsubmenu/index', $data);
    }

    // get data
    public function getsubsubmenu()
    {
        if ($this->request->isAJAX()) {
            $submenu_id = $this->request->getVar('submenu_id');
            $id_grup = session()->get('id_grup');
            $url = 'menu';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);
            $list      =  $this->subsubmenu->listbysub($submenu_id);
            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {

                    $data = [
                        'title'     => 'Setting - Menu Level 3',
                        'list'      =>  $list,
                        'akses'     => $akses

                    ];
                    $msg = [
                        'data' => view('admin/pengaturan/menu/subsubmenu/list', $data)
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

    // ADD subsub menu
    public function formsubsubmenu()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title'             => 'Tambah Menu',
                'submenu_id'        => $this->request->getVar('submenu_id'),
                'modulpublic'       => $this->modulpublic->listaktif(),
                'kategoriberita'    => $this->kategori->list(),
                'halaman'           => $this->berita->listhalaman(),
            ];
            $msg = [
                'data' => view('admin/pengaturan/menu/subsubmenu/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpansubsubmenu()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_subsubmenu' => [
                    'label' => 'Nama Menu',
                    'rules' => 'required|is_unique[subsubmenu.nama_subsubmenu]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ],

                'link_subsubmenu' => [
                    'label' => 'Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],

                'urutanssm' => [
                    'label' => 'Uratan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_subsubmenu' => $validation->getError('nama_subsubmenu'),
                        'link_subsubmenu' => $validation->getError('link_subsubmenu'),
                        'urutanssm'       => $validation->getError('urutanssm'),
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_subsubmenu'      => $this->request->getVar('nama_subsubmenu'),
                    'submenu_id'        => $this->request->getVar('submenu_id'),
                    'link_subsubmenu'   => $this->request->getVar('link_subsubmenu'),
                    'iconssm'           => $this->request->getVar('iconssm'),
                    'urutanssm'         => $this->request->getVar('urutanssm'),
                    'targetssm'         => $this->request->getVar('targetssm'),
                    'linkexternalssm'   => $this->request->getVar('linkexternalssm'),
                    'stsssm'            => '1'

                ];

                $this->subsubmenu->insert($simpandata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditsubsubmenu()
    {
        if ($this->request->isAJAX()) {
            $subsubmenu_id = $this->request->getVar('subsubmenu_id');
            $list =  $this->subsubmenu->find($subsubmenu_id);
            $data = [
                'title'          => 'Edit Menu',
                'subsubmenu_id'     => $list['subsubmenu_id'],
                'submenu_id'        => $list['submenu_id'],
                'nama_subsubmenu'   => $list['nama_subsubmenu'],
                'link_subsubmenu'   => $list['link_subsubmenu'],
                'iconssm'          => $list['iconssm'],
                'urutanssm'        => $list['urutanssm'],
                'targetssm'        => $list['targetssm'],
                'linkexternalssm'  => $list['linkexternalssm'],

                'kategoriberita'    => $this->kategori->list(),
                'halaman'           => $this->berita->listhalaman(),
                'modulpublic'       => $this->modulpublic->listaktif(),

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/menu/subsubmenu/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatesubsubmenu()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_subsubmenu' => [
                    'label' => 'Nama Sub Menu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'link_subsubmenu' => [
                    'label' => 'Menu Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'urutanssm' => [
                    'label' => 'Uratan Sub Menu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_subsubmenu' => $validation->getError('nama_subsubmenu'),
                        'link_subsubmenu' => $validation->getError('link_subsubmenu'),
                        'urutanssm' => $validation->getError('urutanssm'),
                    ]
                ];
            } else {
                $updatedata = [

                    'nama_subsubmenu' => $this->request->getVar('nama_subsubmenu'),
                    'link_subsubmenu' => $this->request->getVar('link_subsubmenu'),
                    // 'menu_id' => $this->request->getVar('menu_id'),
                    'iconssm' => $this->request->getVar('iconssm'),
                    'urutanssm' => $this->request->getVar('urutanssm'),
                    'linkexternalssm' => $this->request->getVar('linkexternalssm'),
                    'targetssm' => $this->request->getVar('targetssm'),
                    'parentssm' => $this->request->getVar('parentssm')

                ];

                $subsubmenu_id = $this->request->getVar('subsubmenu_id');
                $this->subsubmenu->update($subsubmenu_id, $updatedata);
                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapussubsubmenu()
    {
        if ($this->request->isAJAX()) {

            $subsubmenu_id = $this->request->getVar('subsubmenu_id');

            $this->subsubmenu->delete($subsubmenu_id);
            $msg = [
                'sukses' => 'Menu Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    //publish dan unpublish sub menu
    public function togglesubsub()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('subsubmenu_id');
            $cari =  $this->subsubmenu->find($id);

            if ($cari['stsssm'] == '1') {
                $list =  $this->subsubmenu->getaktif($id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'stsssm'        => $toggle,
                ];
                $this->subsubmenu->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil Non Aktifkan!'
                ];
            } else {
                $list =  $this->subsubmenu->getnonaktif($id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'stsssm'        => $toggle,
                ];
                $this->subsubmenu->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil Mengaktifkan!'
                ];
            }

            echo json_encode($msg);
        }
    }
}
