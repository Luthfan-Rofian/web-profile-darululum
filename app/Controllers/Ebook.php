<?php

namespace App\Controllers;

class Ebook extends BaseController
{

    public function index()
    {

        $konfigurasi        = $this->konfigurasi->vkonfig();
        $ebook = $this->ebook->listebookpage();
        $template = $this->template->tempaktif();
        $data = [
            'title'         => 'E-Book | ' . $konfigurasi->nama,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),
            'ebook'         => $ebook->paginate(6, 'hal'),
            'pager'         => $ebook->pager,
            'jum'           => $this->ebook->totebook(),
            'banner'        => $this->banner->list(),
            'infografis'    => $this->banner->listinfo(),
            'infografis1'   => $this->banner->listinfo1(),
            'agenda'        => $this->agenda->listagendapage()->paginate(4),
            'section'       => $this->section->list(),
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'beritaterkini' => $this->berita->terkini(),
            'kategori' => $this->kategoriebook->orderBy('kategoriebook_id', 'ASC')->findAll(),
            'infografis10'    => $this->banner->listinfopage()->paginate(10),
            'kategoriberita'      => $this->kategori->list(),
            'folder'        => $template['folder']
        ];
        return view('' . $template['folder'] . '/' . 'content/semua_ebook', $data);
    }

    public function bacaebook($fileebook = null)
    {
        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();

        $data = [
            'title'         => 'Baca Buku',
            'fileebok'      => $fileebook,
            'konfigurasi'   => $konfigurasi,

        ];
        return view('admin/modal/flipbook', $data);
    }

    //update hit
    public function getebook()
    {
        if ($this->request->isAJAX()) {

            $ebook_id = $this->request->getVar('ebook_id');
            $list =  $this->ebook->find($ebook_id);
            $data = [
                'hits'        => $list['hits'] + 1
            ];
            $this->ebook->update($list['ebook_id'], $data);
            $msg = [];
            echo json_encode($msg);
        }
    }

    public function all()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'        => 'E-book',
            'subtitle'        => 'Data E-book',
        ];

        return view('admin/cmscust/ebook/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $id = session()->get('id');
            $url = 'ebook/all';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($akses == 1) {
                $list = $this->ebook->listebook();
            } elseif ($akses == 2) {
                $list = $this->ebook->listebookauthor($id);
            }
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Data E-book',
                        'list'      => $list,
                        'akses'     => $akses

                    ];
                    $msg = [
                        'data' => view('admin/cmscust/ebook/list', $data)
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

    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Ebook',
                'kategori' => $this->kategoriebook->orderBy('kategoriebook_id', 'ASC')->findAll()
            ];
            $msg = [
                'data' => view('admin/cmscust/ebook/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanEbook()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            // $bts = 50000;
            $valid = $this->validate([
                'judul' => [
                    'label' => 'Judul Ebook',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        // 'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'kategoriebook_id' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],

                'fileebook' => [
                    'label' => 'File Ebook',
                    'rules' => [
                        'max_size[fileebook,50096]',
                        'uploaded[fileebook]',
                        'mime_in[fileebook,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                    ],
                    'errors' => [
                        'max_size' => 'Ukuran {field} Maksimal 50096 KB..!!',
                        'uploaded' => 'Silahkan Masukkan file',
                        'mime_in' => 'Format file harus PDF..!!'
                    ]
                ],
                'gambar' => [
                    'label' => 'Cover',
                    'rules' => 'max_size[gambar,5024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
                    'errors' => [
                        'max_size' => 'Ukuran {field} Maksimal 5024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'judul'             => $validation->getError('judul'),
                        'kategoriebook_id'  => $validation->getError('kategoriebook_id'),
                        'fileebook'         => $validation->getError('fileebook'),
                        'gambar'            => $validation->getError('gambar'),
                    ]
                ];
                echo json_encode($msg);
            } else {

                $userid = session()->get('id');
                $filegambar = $this->request->getFile('gambar');
                $nama_cover = $filegambar->getRandomName();

                $fileebook = $this->request->getFile('fileebook');
                $nama_ebook = $fileebook->getRandomName();

                $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                $ceksts = $konfigurasi['sts_posting'];

                // cek role berita
                $id_grup = session()->get('id_grup');
                $urlget = 'ebook/all';
                $listgrupf =  $this->grupakses->listgrupakses($id_grup, $urlget);

                foreach ($listgrupf as $data) :
                    $akses = $data['akses'];
                endforeach;

                if ($listgrupf) {
                    if ($akses == '1') {
                        $stspos = 1;
                    } else {
                        if ($ceksts == 1) {
                            $stspos = 0;
                        } else {
                            $stspos = 1;
                        }
                    }
                }

                //jika gambar tidak ada
                if ($filegambar->GetError() == 4) {

                    $insertdata = [

                        'kategoriebook_id'   => $this->request->getVar('kategoriebook_id'),
                        'judul'              => $this->request->getVar('judul'),
                        'gambar'             => 'default.png',
                        'fileebook'          => $nama_ebook,
                        'penulis'            => $this->request->getVar('penulis'),
                        'j_hal'              => $this->request->getVar('j_hal'),
                        'tanggal'            => date('Y-m-d'),
                        'hits'               => '0',
                        'status'             => $stspos,
                        'id'                 => $userid,

                    ];

                    $this->ebook->insert($insertdata);
                    $fileebook->move('public/deploy/pdf/', $nama_ebook); //pdf ebook

                    $msg = [
                        'sukses' => 'E-Book berhasil disimpan!'
                    ];
                } else {

                    $insertdata = [

                        'kategoriebook_id'   => $this->request->getVar('kategoriebook_id'),
                        'judul'              => $this->request->getVar('judul'),
                        'gambar'             => $nama_cover,
                        'fileebook'          => $nama_ebook,
                        'penulis'            => $this->request->getVar('penulis'),
                        'j_hal'              => $this->request->getVar('j_hal'),
                        'tanggal'            => date('Y-m-d'),
                        'hits'               => '0',
                        'status'             => $stspos,
                        'id'                 => $userid,
                    ];

                    $this->ebook->insert($insertdata);

                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->fit(774, 1000, 'center')
                        ->save('public/img/ebook/thumb/' . 'thumb_' .  $nama_cover, 65);

                    $filegambar->move('public/img/ebook/', $nama_cover); //folder cover
                    $fileebook->move('public/deploy/pdf/', $nama_ebook); //pdf ebook

                    $msg = [
                        'sukses' => 'E-Book berhasil disimpan!'
                    ];
                }
                echo json_encode($msg);
            }
        }
    }

    public function formlihat()
    {
        if ($this->request->isAJAX()) {
            $ebook_id = $this->request->getVar('ebook_id');
            $kat = $this->request->getVar('kategoriebook_nama');
            $list =  $this->ebook->find($ebook_id);

            $data = [
                'title'      => 'Detail Book',
                'ebook_id'   => $list['ebook_id'],
                'judul'      => $list['judul'],
                'kategori'   => $kat,
                'fileebook'  => $list['fileebook'],
                'penulis'    => $list['penulis'],
                'j_hal'      => $list['j_hal'],
                'hits'       => $list['hits'],
                'tanggal'    => $list['tanggal'],
                'gambar'     => $list['gambar']

            ];
            $msg = [
                'sukses' => view('admin/cmscust/ebook/lihatbook', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $ebook_id = $this->request->getVar('ebook_id');
            $list =  $this->ebook->find($ebook_id);
            $data = [
                'title'               => 'Edit Ebook',
                'ebook_id'            => $list['ebook_id'],
                'judul'               => $list['judul'],
                'fileebook'           => $list['fileebook'],
                'penulis'             => $list['penulis'],
                'j_hal'               => $list['j_hal'],
                'kategoriebook_id'    => $list['kategoriebook_id'],
                'kategoriebook'        => $this->kategoriebook->list()
            ];
            $msg = [
                'sukses' => view('admin/cmscust/ebook/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {

            $ebook_id = $this->request->getVar('ebook_id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'judul' => [
                    'label' => 'Judul Ebook',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'kategoriebook_id' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'fileebook' => [
                    'label' => 'File Ebook',
                    'rules' => [
                        // 'uploaded[fileebook]',
                        'mime_in[fileebook,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                        'max_size[fileebook,50096]',
                    ],
                    'errors' => [
                        // 'uploaded' => 'Silahkan Masukkan file',
                        'max_size' => 'Ukuran {field} Maksimal 50096 KB..!!',
                        'mime_in' => 'Format file harus PDF..!!'
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'judul' => $validation->getError('judul'),
                        'kategorifoto_id' => $validation->getError('kategorifoto_id'),
                        'fileebook' => $validation->getError('fileebook')
                    ]
                ];
            } else {

                $fileebook = $this->request->getFile('fileebook');
                $nama_ebook = $fileebook->getRandomName();
                //jika edit saja
                if ($fileebook->GetError() == 4) {
                    $data = [

                        'kategoriebook_id'   => $this->request->getVar('kategoriebook_id'),
                        'judul'              => $this->request->getVar('judul'),
                        'penulis'            => $this->request->getVar('penulis'),
                        'j_hal'              => $this->request->getVar('j_hal'),
                    ];

                    $this->ebook->update($ebook_id, $data);
                    $msg = [
                        'sukses' => 'Data berhasil diubah!'
                    ];
                } else {

                    //check
                    $cekdata = $this->ebook->find($ebook_id);
                    $ebooklama = $cekdata['fileebook'];
                    if ($ebooklama != '') {
                        unlink('public/deploy/pdf/' . $ebooklama);
                    }

                    $updatedata = [
                        'kategoriebook_id'   => $this->request->getVar('kategoriebook_id'),
                        'judul'              => $this->request->getVar('judul'),
                        'penulis'            => $this->request->getVar('penulis'),
                        'j_hal'              => $this->request->getVar('j_hal'),
                        'fileebook'          => $nama_ebook,
                    ];

                    $this->ebook->update($ebook_id, $updatedata);
                    $fileebook->move('public/deploy/pdf/', $nama_ebook); //pdf ebook

                    $msg = [
                        'sukses' => 'Data berhasil diubah!'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    // aktif non aktifkan

    public function toggle()
    {
        if ($this->request->isAJAX()) {
            $ebook_id = $this->request->getVar('ebook_id');
            $cari =  $this->ebook->find($ebook_id);

            if ($cari['status'] == '1') {
                $list =  $this->ebook->getaktif($ebook_id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'status'        => $toggle,
                ];

                $this->ebook->update($ebook_id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil nonaktifkan ebook!'
                ];
            } else {
                $list =  $this->ebook->getnonaktif($ebook_id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'status'        => $toggle,
                ];

                $this->ebook->update($ebook_id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil mengaktifkan ebook!'
                ];
            }

            echo json_encode($msg);
        }
    }

    // gnti cover
    public function formganticover()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('ebook_id');
            $list =  $this->ebook->find($id);
            $data = [
                'title'    => 'Upload Cover',
                'id'       => $list['ebook_id'],
                'gambar'   => $list['gambar']

            ];
            $msg = [
                'sukses' => view('admin/cmscust/ebook/ganticover', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function douploadCover()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('ebook_id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'gambar' => [
                    'label' => 'Cover halaman',
                    'rules' => 'uploaded[gambar]|max_size[gambar,1024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
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
                        'gambar' => $validation->getError('gambar')
                    ]
                ];
            } else {

                //check
                $cekdata = $this->ebook->find($id);
                $fotolama = $cekdata['gambar'];

                if ($fotolama != 'default.png') {
                    unlink('public/img/ebook/' . $fotolama);
                    unlink('public/img/ebook/thumb/' . 'thumb_' . $fotolama);
                }

                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();

                $updatedata = [
                    'gambar' => $nama_file
                ];

                $this->ebook->update($id, $updatedata);

                \Config\Services::image()
                    ->withFile($filegambar)
                    ->fit(774, 1000, 'center')
                    ->save('public/img/ebook/thumb/' . 'thumb_' .  $nama_file, 65);

                $filegambar->move('public/img/ebook/', $nama_file); //folder foto

                $msg = [
                    'sukses' => 'Cover berhasil diganti!',
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $ebook_id = $this->request->getVar('ebook_id');
            //check cover
            $cekdata = $this->ebook->find($ebook_id);

            $fotolama = $cekdata['gambar'];
            $filepdf = $cekdata['fileebook'];

            if ($fotolama != 'default.png' && file_exists('public/img/ebook/' . $fotolama)) {
                unlink('public/img/ebook/' . $fotolama);
            }

            if ($fotolama != 'default.png' && file_exists('public/img/ebook/thumb/' . 'thumb_' . $fotolama)) {
                unlink('public/img/ebook/thumb/' . 'thumb_' . $fotolama);
            }

            if ($filepdf != '' && file_exists('public/deploy/pdf/' . $filepdf)) {
                unlink('public/deploy/pdf/' . $filepdf);
            }

            // if ($fotolama != 'default.png') {
            //     unlink('public/img/ebook/' . $fotolama);
            //     unlink('public/img/ebook/thumb/' . 'thumb_' . $fotolama);
            // }
            // if ($filepdf != '') {
            //     unlink('public/deploy/pdf/' . $filepdf);
            // }

            $this->ebook->delete($ebook_id);
            $msg = [
                'sukses' => 'Data berhasil dihapus!'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $ebook_id = $this->request->getVar('ebook_id');
            $jmldata = count($ebook_id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->ebook->find($ebook_id[$i]);
                $fotolama = $cekdata['gambar'];
                $filepdf = $cekdata['fileebook'];

                if ($fotolama != 'default.png' && file_exists('public/img/ebook/' . $fotolama)) {
                    unlink('public/img/ebook/' . $fotolama);
                }

                if ($fotolama != 'default.png' && file_exists('public/img/ebook/thumb/' . 'thumb_' . $fotolama)) {
                    unlink('public/img/ebook/thumb/' . 'thumb_' . $fotolama);
                }

                if ($filepdf != '' && file_exists('public/deploy/pdf/' . $filepdf)) {
                    unlink('public/deploy/pdf/' . $filepdf);
                }

                $this->ebook->delete($ebook_id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata data berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    //Start kategori (backend)
    public function kategori()

    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'       => 'Ebook',
            'subtitle'    => 'Kategori',
        ];
        return view('admin/cmscust/ebook/kategoriebook/index', $data);
    }

    public function getkategori()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'ebook/kategori';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1') {
                    $data = [
                        'title'     => 'Kategori - Ebook',
                        'list'      => $this->kategoriebook->orderBy('kategoriebook_id', 'ASC')->findAll(),
                        'akses'     => '1'
                    ];
                    $msg = [
                        'data' => view('admin/cmscust/ebook/kategoriebook/list', $data)
                    ];
                } elseif ($akses == '2') {

                    $data = [
                        'title'     => 'Kategori - Ebook',
                        'list'      => $this->kategoriebook->orderBy('kategoriebook_id', 'ASC')->findAll(),
                        'akses'     => '2'
                    ];
                    $msg = [
                        'data' => view('admin/cmscust/ebook/kategoriebook/list', $data)
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
            // $data = [
            //     'title' => 'Kategori - Ebook',
            //     'list' => $this->kategoriebook->orderBy('kategoriebook_id', 'ASC')->findAll()
            // ];
            // $msg = [
            //     'data' => view('admin/cmscust/ebook/kategoriebook/list', $data)
            // ];
            echo json_encode($msg);
        }
    }

    public function formkategori()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Kategori'
            ];
            $msg = [
                'data' => view('admin/cmscust/ebook/kategoriebook/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpankategori()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'kategoriebook_nama' => [
                    'label' => 'Kategori',
                    'rules' => 'required|is_unique[kategori_ebook.kategoriebook_nama]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'kategoriebook_nama' => $validation->getError('kategoriebook_nama'),
                    ]
                ];
            } else {
                $simpandata = [
                    'kategoriebook_nama' => $this->request->getVar('kategoriebook_nama'),
                    'kategoriebook_slug' => $this->request->getVar('kategoriebook_slug'),
                ];

                $this->kategoriebook->insert($simpandata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditkategori()
    {
        if ($this->request->isAJAX()) {
            $kategoriebook_id = $this->request->getVar('kategoriebook_id');
            $list =  $this->kategoriebook->find($kategoriebook_id);
            $data = [
                'title'                 => 'Edit Kategori',
                'kategoriebook_id'     => $list['kategoriebook_id'],
                'kategoriebook_nama'   => $list['kategoriebook_nama'],
            ];
            $msg = [
                'sukses' => view('admin/cmscust/ebook/kategoriebook/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatekategori()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'kategoriebook_nama' => [
                    'label' => 'Nama Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'kategoriebook_nama' => $validation->getError('kategoriebook_nama'),
                    ]
                ];
            } else {
                $updatedata = [
                    'kategoriebook_nama' => $this->request->getVar('kategoriebook_nama'),
                    'kategoriebook_slug' => $this->request->getVar('kategoriebook_slug'),
                ];

                $kategoriebook_id = $this->request->getVar('kategoriebook_id');
                $this->kategoriebook->update($kategoriebook_id, $updatedata);
                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapuskategori()
    {
        if ($this->request->isAJAX()) {

            $kategoriebook_id = $this->request->getVar('kategoriebook_id');

            $this->kategoriebook->delete($kategoriebook_id);
            $msg = [
                'sukses' => 'Kategori Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }
    //end kategori

}
