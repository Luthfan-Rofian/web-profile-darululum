<?php

namespace App\Controllers;

class Foto extends BaseController
{

    public function index()
    {

        $konfigurasi        = $this->konfigurasi->vkonfig();
        $foto = $this->foto->listfotopage();

        $album = $this->kategorifoto->listalbumpage();

        $template = $this->template->tempaktif();
        $data = [
            'title'         => 'Foto | ' . $konfigurasi->nama,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),
            'foto'          => $foto->paginate(12, 'hal'),
            'album'         => $album->paginate(12, 'hal'),
            'pager'         => $album->pager,
            'jum'           => $this->foto->totfoto(),
            'jumpg'         => $this->foto->jumalbum(),
            'banner'        => $this->banner->list(),
            'infografis'    => $this->banner->listinfo(),
            'infografis1'   => $this->banner->listinfo1(),
            'agenda'        => $this->agenda->listagendapage()->paginate(4),
            'section'       => $this->section->list(),
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'infografis10'    => $this->banner->listinfopage()->paginate(10),
            'kategori'      => $this->kategori->list(),
            'folder'        => $template['folder']

        ];
        return view('' . $template['folder'] . '/' . 'content/semua_foto', $data);
    }

    //lihat foto front end

    public function formlihatfoto()
    {
        if ($this->request->isAJAX()) {
            $foto_id = $this->request->getVar('foto_id');
            $kategori = $this->request->getVar('nama_kategori_foto');

            $list =  $this->foto->find($foto_id);
            $data = [
                'title'        => 'Galeri - Foto',
                'foto_id'      => $list['foto_id'],
                'judul'        => $list['judul'],
                'gambar'       => $list['gambar'],
                'kategorifoto' => $kategori
            ];
            $msg = [

                'sukses' => view('admin/modal/v_foto', $data)
            ];
            echo json_encode($msg);
        }
    }

    // START BACK by kategori
    public function all()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'        => 'Galeri',
            'subtitle'     => 'Foto',
        ];

        return view('admin/galeri/foto/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'foto/all';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Album Foto',
                        'list'      => $this->kategorifoto->orderBy('kategorifoto_id', 'ASC')->findAll(),
                        'akses'     => $akses
                    ];
                    $msg = [
                        'data' => view('admin/galeri/foto/list', $data)
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

    // edit detail
    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $foto_id = $this->request->getVar('foto_id');
            $list =  $this->foto->find($foto_id);
            $data = [
                'title'         => 'Edit Galeri Foto',
                'foto_id'       => $list['foto_id'],
                'judul'         => $list['judul'],
                'gambar'        => $list['gambar'],
                'kategorifoto_id'    => $list['kategorifoto_id'],
                'kategorifoto' => $this->kategorifoto->list()
            ];
            $msg = [
                'sukses' => view('admin/galeri/foto/detail/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatefoto()
    {
        if ($this->request->isAJAX()) {

            $foto_id = $this->request->getVar('foto_id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'judul' => [
                    'label' => 'Keterangan Foto',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'kategorifoto_id' => [
                    'label' => 'Kategori Foto',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'gambar' => [
                    'label' => 'gambar',
                    'rules' => 'max_size[gambar,1024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
                    'errors' => [
                        // 'uploaded' => 'Masukkan gambar',
                        'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'judul' => $validation->getError('judul'),
                        'kategorifoto_id' => $validation->getError('kategorifoto_id'),
                        'gambar' => $validation->getError('gambar')
                    ]
                ];
            } else {
                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();
                //jika edit saja
                if ($filegambar->GetError() == 4) {
                    $data = [
                        'judul'         => $this->request->getVar('judul'),
                        'kategorifoto_id'   => $this->request->getVar('kategorifoto_id')
                    ];

                    $this->foto->update($foto_id, $data);
                    $msg = [
                        'sukses' => 'Data berhasil diubah!'
                    ];
                } else {

                    //check
                    $cekdata = $this->foto->find($foto_id);
                    $fotolama = $cekdata['gambar'];
                    if ($fotolama != '' && file_exists('public/img/galeri/foto/' . $fotolama)) {
                        unlink('public/img/galeri/foto/' . $fotolama);
                    }
                    if ($fotolama != '' && file_exists('public/img/galeri/foto/thumb/' . 'thumb_' . $fotolama)) {
                        unlink('public/img/galeri/foto/thumb/' . 'thumb_' . $fotolama);
                    }

                    $updatedata = [
                        'judul'   => $this->request->getVar('judul'),
                        'kategorifoto_id'   => $this->request->getVar('kategorifoto_id'),
                        'gambar' => $nama_file
                    ];

                    $this->foto->update($foto_id, $updatedata);

                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->fit(530, 331, 'center')
                        ->save('public/img/galeri/foto/thumb/' . 'thumb_' .  $nama_file, 65);

                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->save('public/img/galeri/foto/' . $nama_file, 65);

                    $msg = [
                        'sukses' => 'Data berhasil diubah!'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    // hapus detail
    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $foto_id = $this->request->getVar('foto_id');
            //check
            $cekdata = $this->foto->find($foto_id);
            $fotolama = $cekdata['gambar'];

            if ($fotolama != '' && file_exists('public/img/galeri/foto/' . $fotolama)) {
                unlink('public/img/galeri/foto/' . $fotolama);
            }
            if ($fotolama != '' && file_exists('public/img/galeri/foto/thumb/' . 'thumb_' . $fotolama)) {
                unlink('public/img/galeri/foto/thumb/' . 'thumb_' . $fotolama);
            }
            $this->foto->delete($foto_id);
            $msg = [
                'sukses' => 'Data berhasil dihapus!'
            ];

            echo json_encode($msg);
        }
    }
    // hapus all detail
    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $foto_id = $this->request->getVar('foto_id');
            $jmldata = count($foto_id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->foto->find($foto_id[$i]);
                $fotolama = $cekdata['gambar'];

                if ($fotolama != '' && file_exists('public/img/galeri/foto/' . $fotolama)) {
                    unlink('public/img/galeri/foto/' . $fotolama);
                }
                if ($fotolama != '' && file_exists('public/img/galeri/foto/thumb/' . 'thumb_' . $fotolama)) {
                    unlink('public/img/galeri/foto/thumb/' . 'thumb_' . $fotolama);
                }

                $this->foto->delete($foto_id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata foto berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    //Detail front end
    public function detail($kategorifoto_id = null)
    {
        if (!isset($kategorifoto_id)) return redirect()->to('/foto');
        $konfigurasi    = $this->konfigurasi->vkonfig();
        $template       = $this->template->tempaktif();

        $foto = $this->foto->detail_foto($kategorifoto_id);
        $kategori = $this->kategori->list();

        if ($foto) {

            $data = [
                'title'         => 'Foto | ' . $konfigurasi->nama,
                'deskripsi'     => $konfigurasi->deskripsi,
                'url'           => $konfigurasi->website,
                'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),

                'konfigurasi'    => $konfigurasi,
                'foto'           => $foto,
                'beritapopuler' => $this->berita->populer()->paginate(8),
                'kategori'       => $kategori,
                'mainmenu'       => $this->menu->mainmenu(),
                'footer'         => $this->menu->footermenu(),
                'topmenu'        => $this->menu->topmenu(),
                'banner'         => $this->banner->list(),
                'infografis'     => $this->banner->listinfo(),
                'infografis1'    => $this->banner->listinfo1(),
                'agenda'         => $this->agenda->listagendapage()->paginate(4),
                'linkterkaitall'    => $this->linkterkait->publishlinkall(),
                'albumlain'     => $this->kategorifoto->listalbumlain($kategorifoto_id)->paginate(4),
                'folder'        => $template['folder'],

            ];
            return view('' . $template['folder'] . '/' . 'content/detailfoto', $data);
        } else {
            return redirect()->to('/foto');
        }
    }

    // start detail backend

    public function det($kategorifoto_id = null)
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($kategorifoto_id == '') {
            return redirect()->to(base_url('foto/list'));
        }

        $data = [
            'title'            => 'Foto',
            'subtitle'         => 'Detail',
            'kategorifoto_id'  => $kategorifoto_id,
        ];

        return view('admin/galeri/foto/detail/index', $data);
    }

    // get data detail foto
    public function getdetailft()
    {
        if ($this->request->isAJAX()) {

            $id_grup = session()->get('id_grup');
            $id = session()->get('id');
            $kategorifoto_id = $this->request->getVar('kategorifoto_id');
            $list =  $this->foto->detail_foto($kategorifoto_id);
            $listbyid =  $this->foto->detail_fotobyid($kategorifoto_id, $id);

            $url = 'foto/all';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses

                if ($akses == '1') {
                    $data = [
                        'title'      => 'Detail foto',
                        'list'       => $list,
                        'akses'     => '1'
                    ];
                    $msg = [
                        'data' => view('admin/galeri/foto/detail/list', $data)
                    ];
                } elseif ($akses == '2') {

                    $data = [
                        'title'      => 'Detail foto',
                        'list'       => $listbyid,
                        'akses'     => '2'
                    ];
                    $msg = [
                        'data' => view('admin/galeri/foto/detail/list', $data)
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

    //tambah multi
    public function uploadmulti()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title'           => 'Tambah Foto',
                'kategorifoto_id' => $this->request->getVar('kategorifoto_id'),
                // 'kategori' => $this->kategoriproduk->orderBy('kategorilapak_id', 'ASC')->findAll()
            ];
            $msg = [
                'data' => view('admin/galeri/foto/detail/formmultiadd', $data)
            ];
            echo json_encode($msg);
        }
    }

    //simpan multi detail

    public function simpanmulti()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'judul' => [
                    'label' => 'Keterangan Foto',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],

                'gambar' => [
                    'label' => 'gambar',
                    'rules' => 'uploaded[gambar]|max_size[gambar,3024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
                    'errors' => [
                        'uploaded' => 'Silahkan Masukkan gambar!',
                        'max_size' => 'Ukuran {field} Maksimal 3024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'judul'       => $validation->getError('judul'),
                        'gambar'      => $validation->getError('gambar')
                    ]
                ];
            } else {

                $upload = $this->request->getFiles();
                $i = 0;
                $judul  = $this->request->getVar('judul');
                $userid = session()->get('id');
                foreach ($upload['gambar'] as $upl) {

                    $nama_file = $upl->getRandomName();
                    $insert = array(
                        'judul'             => $judul[$i],
                        'kategorifoto_id'   => $this->request->getVar('kategorifoto_id'),
                        'gambar'            => $nama_file,
                        'tanggal'           => date('Y-m-d'),
                        'id'                => $userid,
                    );

                    $this->foto->insert($insert);
                    // $upl->move('public/img/produk/detail/', $nama_file, 60);

                    \Config\Services::image()
                        ->withFile($upl)
                        ->fit(530, 331, 'center')
                        ->save('public/img/galeri/foto/thumb/' . 'thumb_' .  $nama_file, 60);

                    \Config\Services::image()
                        ->withFile($upl)
                        ->save('public/img/galeri/foto/' . $nama_file, 60);

                    $i++;
                }

                $msg = [
                    'sukses' => 'Data berhasil disimpan!'
                ];
            }
            echo json_encode($msg);
        }
    }

    // end detail

    //Start kategori (backend)

    public function formkategori()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Kategori'
            ];
            $msg = [
                'data' => view('admin/galeri/foto/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpankategori()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama_kategori_foto' => [
                    'label' => 'Kategori',
                    'rules' => 'required|is_unique[kategori_foto.nama_kategori_foto]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ],

                'cover_foto' => [
                    'label' => 'Cover',
                    'rules' => 'max_size[cover_foto,3024]|mime_in[cover_foto,image/png,image/jpg,image/jpeg,image/gif]|is_image[cover_foto]',
                    'errors' => [
                        // 'uploaded' => 'Silahkan Masukkan cover_foto',
                        'max_size' => 'Ukuran {field} Maksimal 3024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_kategori_foto'  => $validation->getError('nama_kategori_foto'),
                        'cover_foto'          => $validation->getError('cover_foto'),
                    ]
                ];
                echo json_encode($msg);
            } else {


                $filegambar = $this->request->getFile('cover_foto');
                $nama_file = $filegambar->getRandomName();

                //jika gambar tidak ada
                if ($filegambar->GetError() == 4) {

                    $insertdata = [
                        'nama_kategori_foto' => $this->request->getVar('nama_kategori_foto'),
                        'slug_kategori_foto' => $this->request->getVar('slug_kategori_foto'),
                        'ket'                => $this->request->getVar('ket'),
                        'cover_foto'         => 'default.png',
                        'tgl_album'           => date('Y-m-d'),
                    ];

                    $this->kategorifoto->insert($insertdata);

                    $msg = [
                        'sukses' => 'Kategori foto berhasil disimpan!'
                    ];
                } else {

                    $insertdata = [

                        'nama_kategori_foto'  => $this->request->getVar('nama_kategori_foto'),
                        'slug_kategori_foto'   => mb_url_title($this->request->getVar('nama_kategori_foto'), '-', TRUE),
                        'ket'                => $this->request->getVar('ket'),
                        'cover_foto'        => $nama_file,
                        'tgl_album'           => date('Y-m-d'),
                    ];

                    $this->kategorifoto->insert($insertdata);
                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->save('public/img/galeri/katfoto/' . $nama_file, 70);
                    $msg = [
                        'sukses' => 'Kategori berhasil disimpan!'
                    ];
                }
                echo json_encode($msg);
            }
        }
    }

    public function ganticoverkat()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('kategorifoto_id');
            $list =  $this->kategorifoto->find($id);
            $data = [
                'title'       => 'Ganti Cover',
                'id'          => $list['kategorifoto_id'],
                'cover_foto'   => $list['cover_foto']

            ];
            $msg = [
                'sukses' => view('admin/galeri/foto/gantifoto', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function douploadcover()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('kategorifoto_id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'cover_foto' => [
                    'label' => 'Cover halaman',
                    'rules' => 'uploaded[cover_foto]|max_size[cover_foto,2024]|mime_in[cover_foto,image/png,image/jpg,image/jpeg,image/gif]|is_image[cover_foto]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar',
                        'max_size' => 'Ukuran {field} Maksimal 2024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'cover_foto' => $validation->getError('cover_foto')
                    ]
                ];
            } else {

                //check
                $cekdata = $this->kategorifoto->find($id);
                $fotolama = $cekdata['cover_foto'];

                if ($fotolama != 'default.png' && file_exists('public/img/galeri/katfoto/' . $fotolama)) {
                    unlink('public/img/galeri/katfoto/' . $fotolama);
                }

                $filegambar = $this->request->getFile('cover_foto');
                $nama_file = $filegambar->getRandomName();

                $updatedata = [
                    'cover_foto' => $nama_file
                ];

                $this->kategorifoto->update($id, $updatedata);

                \Config\Services::image()
                    ->withFile($filegambar)
                    ->save('public/img/galeri/katfoto/' . $nama_file, 70);

                $msg = [
                    'sukses' => 'Cover berhasil diganti!',
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditkategori()
    {
        if ($this->request->isAJAX()) {
            $kategorifoto_id = $this->request->getVar('kategorifoto_id');
            $list =  $this->kategorifoto->find($kategorifoto_id);
            $data = [
                'title'               => 'Edit Kategori',
                'kategorifoto_id'     => $list['kategorifoto_id'],
                'nama_kategori_foto'  => $list['nama_kategori_foto'],
                'ket'                 => $list['ket'],
                'tgl_album'                 => $list['tgl_album'],

            ];
            $msg = [
                'sukses' => view('admin/galeri/foto/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatekategori()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_kategori_foto' => [
                    'label' => 'Nama Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tgl_album' => [
                    'label' => 'Tanggal',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_kategori_foto' => $validation->getError('nama_kategori_foto'),
                        'tgl_album' => $validation->getError('tgl_album'),
                    ]
                ];
            } else {
                $updatedata = [
                    'nama_kategori_foto'  => $this->request->getVar('nama_kategori_foto'),
                    'ket'                 => $this->request->getVar('ket'),
                    'slug_kategori_foto'  => mb_url_title($this->request->getVar('nama_kategori_foto'), '-', TRUE),
                    'tgl_album'          => date('Y-m-d', strtotime($this->request->getVar('tgl_album'))),
                ];

                $kategorifoto_id = $this->request->getVar('kategorifoto_id');
                $this->kategorifoto->update($kategorifoto_id, $updatedata);
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

            $kategorifoto_id = $this->request->getVar('kategorifoto_id');

            //check
            $cekdata = $this->kategorifoto->find($kategorifoto_id);
            $fotolama = $cekdata['cover_foto'];

            if ($fotolama != 'default.png' && file_exists('public/img/galeri/katfoto/' . $fotolama)) {
                unlink('public/img/galeri/katfoto/' . $fotolama);
            }

            $this->kategorifoto->delete($kategorifoto_id);
            $msg = [
                'sukses' => 'Kategori Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }
    //end kategori

}
