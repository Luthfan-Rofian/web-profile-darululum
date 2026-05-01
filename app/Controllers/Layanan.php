<?php

namespace App\Controllers;

class Layanan extends BaseController
{
    public function index()
    {
        $konfigurasi        = $this->konfigurasi->vkonfig();
        $layanan = $this->layanan->listlayananpage();
        $template = $this->template->tempaktif();
        $data = [
            'title'         => 'Layanan | ' . $konfigurasi->nama,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),
            'layanan'       => $layanan->paginate(6, 'hal'),
            'pager'         => $layanan->pager,
            'jum'           => $this->layanan->totlayanan(),
            'banner'        => $this->banner->list(),
            'infografis'    => $this->banner->listinfo(),
            'infografis10'    => $this->banner->listinfopage()->paginate(10),
            'infografis1'   => $this->banner->listinfo1(),
            'agenda'        => $this->agenda->listagendapage()->paginate(4),
            'beritapopuler' => $this->berita->populer()->paginate(8),
            'kategori'      => $this->kategori->list(),
            'section'       => $this->section->list(),
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'folder'        => $template['folder']
        ];
        return view('' . $template['folder'] . '/' . 'content/semua_layanan', $data);
    }

    //list semua layanan
    public function all()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'        => 'Informasi',
            'subtitle'    => 'Layanan',

        ];
        return view('admin/informasi/layanan/index', $data);
    }


    public function getdata($id = null)
    {
        if ($this->request->isAJAX()) {

            $id_grup = session()->get('id_grup');
            $id          = session()->get('id');
            $url = 'layanan/all';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            if ($akses == 1) {
                $list =  $this->layanan->listlayanan();
            } elseif ($akses == 2) {
                $list = $this->layanan->listlayananauthor($id);
            }
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Layanan',
                        'list'      => $list,
                        'akses'      => $akses
                    ];
                    $msg = [
                        'data' => view('admin/informasi/layanan/list', $data)
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
                'title' => 'Tambah Layanan',
            ];
            $msg = [
                'data' => view('admin/informasi/layanan/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanLayanan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Layanan',
                    'rules' => 'required|is_unique[informasi.nama]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],

                'isi_informasi' => [
                    'label' => 'Deskripsi Layanan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'gambar' => [
                    'label' => 'cover layanan',
                    'rules' => 'max_size[gambar,1024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
                    'errors' => [
                        // 'uploaded' => 'Silahkan Masukkan gambar',
                        'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'           => $validation->getError('nama'),
                        'isi_informasi'  => $validation->getError('isi_informasi'),
                        'gambar'       => $validation->getError('gambar')
                    ]
                ];
                echo json_encode($msg);
            } else {

                $userid = session()->get('id');
                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();

                //jika gambar tidak ada
                if ($filegambar->GetError() == 4) {

                    $insertdata = [
                        'nama'  => $this->request->getVar('nama'),
                        'slug_informasi'   => mb_url_title($this->request->getVar('nama'), '-', TRUE),
                        'isi_informasi'   => $this->request->getVar('isi_informasi'),
                        'tgl_informasi'    => date('Y-m-d'),
                        'gambar'        => 'default.png',
                        'id'            => $userid,
                        'type'            => '0',
                        'hits'            => '0'
                    ];
                    $this->layanan->insert($insertdata);
                    $msg = [
                        'sukses' => 'Layanan berhasil disimpan!'
                    ];
                } else {

                    $insertdata = [
                        'nama'             => $this->request->getVar('nama'),
                        'slug_informasi'   => mb_url_title($this->request->getVar('nama'), '-', TRUE),
                        'isi_informasi'   => $this->request->getVar('isi_informasi'),
                        'tgl_informasi'    => date('Y-m-d'),
                        'gambar'           => $nama_file,
                        'id'              => $userid,
                        'type'            => '0',
                        'hits'            => '0'
                    ];

                    $this->layanan->insert($insertdata);

                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->save('public/img/informasi/layanan/' . $nama_file, 70);
                    $msg = [
                        'sukses' => 'Layanan berhasil disimpan!'
                    ];
                }
                echo json_encode($msg);
            }
        }
    }
    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('informasi_id');
            //check
            $cekdata = $this->layanan->find($id);
            $fotolama = $cekdata['gambar'];
            $filelama = $cekdata['fileunduh'];

            if ($fotolama != 'default.png' && file_exists('public/img/informasi/layanan/' . $fotolama)) {
                unlink('public/img/informasi/layanan/' . $fotolama);
            }
            if ($filelama != '' && file_exists('public/unduh/layanan/' . $filelama)) {
                unlink('public/unduh/layanan/' . $filelama);
            }

            $this->layanan->delete($id);
            $msg = [
                'sukses' => 'Data Layanan Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }


    public function hapusfile()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('informasi_id');
            //check
            $cekdata = $this->layanan->find($id);
            $filelama = $cekdata['fileunduh'];

            if ($filelama != '' && file_exists('public/unduh/layanan/' . $filelama)) {
                unlink('public/unduh/layanan/' . $filelama);
            }

            $updatedata = [
                'fileunduh'           => ''
            ];

            $this->layanan->update($id, $updatedata);

            $msg = [
                'sukses' => 'Data file yang disematkan sukses Dihapus'
            ];

            echo json_encode($msg);
        }
    }


    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('informasi_id');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check gbr
                $cekdata = $this->layanan->find($id[$i]);
                $fotolama = $cekdata['gambar'];
                $filelama = $cekdata['fileunduh'];

                if ($fotolama != 'default.png' && file_exists('public/img/informasi/layanan/' . $fotolama)) {
                    unlink('public/img/informasi/layanan/' . $fotolama);
                }
                if ($filelama != '' && file_exists('public/unduh/layanan/' . $filelama)) {
                    unlink('public/unduh/layanan/' . $filelama);
                }
                $this->layanan->delete($id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata Data layanan berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $informasi_id = $this->request->getVar('informasi_id');
            $list =  $this->layanan->find($informasi_id);

            $data = [
                'title'          => 'Edit Layanan',
                'informasi_id'   => $list['informasi_id'],
                'nama'           => $list['nama'],
                'isi_informasi'  => $list['isi_informasi']

            ];
            $msg = [
                'sukses' => view('admin/informasi/layanan/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatelayanan()
    {
        if ($this->request->isAJAX()) {
            $informasi_id = $this->request->getVar('informasi_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama' => [
                    'label' => 'Nama Layanan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],

                'isi_informasi' => [
                    'label' => 'Deskripsi Layanan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'           => $validation->getError('nama'),
                        'isi_informasi'     => $validation->getError('isi_informasi'),
                    ]
                ];
            } else {

                $updatedata = [

                    'nama'          => $this->request->getVar('nama'),
                    'slug_informasi'   => mb_url_title($this->request->getVar('nama'), '-', TRUE),
                    'isi_informasi'   => $this->request->getVar('isi_informasi'),
                ];
                $this->layanan->update($informasi_id, $updatedata);
                $msg = [
                    'sukses' => 'Data Layanan berhasil diubah!'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formgantifoto()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('informasi_id');
            $list =  $this->layanan->find($id);
            $data = [
                'title'       => 'Ganti Cover',
                'id'          => $list['informasi_id'],
                'gambar'      => $list['gambar']
            ];
            $msg = [
                'sukses' => view('admin/informasi/layanan/gantifoto', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function douploadLayanan()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('informasi_id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'gambar' => [
                    'label' => 'Cover',
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
                $cekdata = $this->layanan->find($id);
                $fotolama = $cekdata['gambar'];

                if ($fotolama != 'default.png' && file_exists('public/img/informasi/layanan/' . $fotolama)) {
                    unlink('public/img/informasi/layanan/' . $fotolama);
                }

                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();

                $updatedata = [
                    'gambar' => $nama_file
                ];

                $this->layanan->update($id, $updatedata);

                \Config\Services::image()
                    ->withFile($filegambar)
                    ->save('public/img/informasi/layanan/' . $nama_file, 70);
                $msg = [
                    'sukses' => 'Cover berhasil diganti!',
                ];
            }
            echo json_encode($msg);
        }
    }

    //Upload file
    public function formuploadfile()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('informasi_id');
            $list =  $this->layanan->find($id);
            $data = [
                'title'       => 'File Unduhan',
                'id'          => $list['informasi_id'],
                'gambar'      => $list['gambar'],
                'fileunduh'      => $list['fileunduh']
            ];
            $msg = [
                'sukses' => view('admin/informasi/layanan/uploadfile', $data)
            ];
            echo json_encode($msg);
        }
    }

    //simpan fileunduh

    public function douploadFileUnduh()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('informasi_id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'fileunduh' => [
                    'label' => 'File unduhan',
                    'rules' => [
                        'uploaded[fileunduh]',
                        'mime_in[fileunduh,image/jpg,image/jpeg,image/gif,image/png,application/pdf,application/doc,application/docx,application/xls,application/xlsx,application/ppt,application/pptx,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                        'max_size[fileunduh,2096]',
                    ],
                    'errors' => [
                        'uploaded' => 'Silahkan Masukkan file',
                        'max_size' => 'Ukuran {field} Maksimal 2096 KB..!!',
                        'mime_in' => 'Format {field} tidak valid..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'fileunduh' => $validation->getError('fileunduh')
                    ]
                ];
            } else {

                //check
                $cekdata = $this->layanan->find($id);
                $filelama = $cekdata['fileunduh'];

                if ($filelama != '' && file_exists('public/unduh/layanan/' . $filelama)) {
                    unlink('public/unduh/layanan/' . $filelama);
                }

                $fileunduhan = $this->request->getFile('fileunduh');
                $nama_file = $fileunduhan->getRandomName();

                $updatedata = [
                    'fileunduh' => $nama_file
                ];

                $this->layanan->update($id, $updatedata);
                $fileunduhan->move('public/unduh/layanan/', $nama_file); //folder foto

                $msg = [
                    'sukses' => 'File berhasil diupload!',
                ];
            }
            echo json_encode($msg);
        }
    }

    //lihat detail layanan front end
    public function formlihatlayanan()
    {
        if ($this->request->isAJAX()) {
            $informasi_id = $this->request->getVar('informasi_id');
            $list =  $this->layanan->find($informasi_id);
            $template = $this->template->tempaktif();
            // Update hits
            $data = [
                'hits'        => $list['hits'] + 1
            ];
            $this->layanan->update($list['informasi_id'], $data);

            $data = [
                'title'          => 'Detail Layanan',
                'informasi_id'   => $list['informasi_id'],
                'nama'           => $list['nama'],
                'isi_informasi'  => $list['isi_informasi'],
                'tgl_informasi'  => $list['tgl_informasi'],
                'gambar'         => $list['gambar'],
                'fileunduh'       => $list['fileunduh']
            ];
            $msg = [

                'sukses' => view('admin/modal/v_layanan', $data)
            ];
            echo json_encode($msg);
        }
    }
    public function formlihatlayananfr()
    {
        if ($this->request->isAJAX()) {
            $informasi_id = $this->request->getVar('informasi_id');
            $list =  $this->layanan->find($informasi_id);
            $template = $this->template->tempaktif();
            // Update hits
            $data = [
                'hits'        => $list['hits'] + 1
            ];
            $this->layanan->update($list['informasi_id'], $data);

            $data = [
                'title'          => 'Detail Layanan',
                'informasi_id'   => $list['informasi_id'],
                'nama'           => $list['nama'],
                'isi_informasi'  => $list['isi_informasi'],
                'tgl_informasi'  => $list['tgl_informasi'],
                'gambar'         => $list['gambar'],
                'fileunduh'       => $list['fileunduh']
            ];
            $msg = [

                'sukses' => view('admin/modal/v_layananfr', $data)
            ];
            echo json_encode($msg);
        }
    }
}
