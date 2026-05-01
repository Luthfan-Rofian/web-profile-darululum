<?php

namespace App\Controllers;

class Linkterkait extends BaseController
{

    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'        => 'Setting',
            'subtitle'    => 'Link Terkait',

        ];
        return view('admin/setkonten/linkterkait/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');

            $url = 'linkterkait';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Link Terkait',
                        'list' => $this->linkterkait->list(),
                        'akses'     => $akses

                    ];
                    $msg = [
                        'data' => view('admin/setkonten/linkterkait/list', $data)
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

    //publish dan unpublish linkterkait
    public function toggle()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $cari =  $this->linkterkait->find($id);

            if ($cari['status'] == '1') {
                $list =  $this->linkterkait->getaktif($id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'status'        => $toggle,
                ];
                $this->linkterkait->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil nonaktifkan link terkait!'
                ];
            } else {
                $list =  $this->linkterkait->getnonaktif($id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'status'        => $toggle,
                ];
                $this->linkterkait->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil mengaktifkan link terkait!'
                ];
            }

            echo json_encode($msg);
        }
    }

    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Link Terkait',

            ];
            $msg = [
                'data' => view('admin/setkonten/linkterkait/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanLink()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama_link' => [
                    'label' => 'Nama Link',
                    'rules' => 'required|is_unique[link_terkait.nama_link]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],

                'url' => [
                    'label' => 'Alamat URL',
                    'rules' => 'required|valid_url',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'valid_url' => '{field} tidak valid'
                    ]
                ],

                'gambar' => [
                    'label' => 'logo link terkait',
                    'rules' => 'max_size[gambar,1024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
                    'errors' => [

                        'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_link'  => $validation->getError('nama_link'),
                        'url'           => $validation->getError('url'),
                        'gambar'       => $validation->getError('gambar')
                    ]
                ];
                echo json_encode($msg);
            } else {

                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();

                //jika gambar tidak ada
                if ($filegambar->GetError() == 4) {

                    $insertdata = [

                        'nama_link'  => $this->request->getVar('nama_link'),

                        'url'           => $this->request->getVar('url'),
                        'status'        => '1',
                        'gambar'        => 'url.png'

                    ];

                    $this->linkterkait->insert($insertdata);

                    $msg = [
                        'sukses' => 'Link terkait berhasil disimpan!'
                    ];
                } else {

                    $insertdata = [

                        'nama_link'  => $this->request->getVar('nama_link'),
                        'url'           => $this->request->getVar('url'),
                        'status'        => '1',
                        'gambar'        => $nama_file,

                    ];

                    $this->linkterkait->insert($insertdata);
                    $filegambar->move('public/img/linkterkait/', $nama_file); //folder gambar

                    $msg = [
                        'sukses' => 'Link terkait berhasil disimpan!'
                    ];
                }
                echo json_encode($msg);
            }
        }
    }
    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id_link');
            //check
            $cekdata = $this->linkterkait->find($id);
            $fotolama = $cekdata['gambar'];
            if ($fotolama != 'url.png' && file_exists('public/img/linkterkait/' . $fotolama)) {

                unlink('public/img/linkterkait/' . $fotolama);
            }
            $this->linkterkait->delete($id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_link');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->linkterkait->find($id[$i]);
                $fotolama = $cekdata['gambar'];
                if ($fotolama != 'url.png' && file_exists('public/img/linkterkait/' . $fotolama)) {
                    unlink('public/img/linkterkait/' . $fotolama);
                }
                $this->linkterkait->delete($id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata Data link terkait berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $id_link = $this->request->getVar('id_link');
            $list =  $this->linkterkait->find($id_link);

            $data = [
                'title'       => 'Edit Link Terkait',
                'id_link'     => $list['id_link'],
                'nama_link'   => $list['nama_link'],
                'url'         => $list['url']

            ];
            $msg = [
                'sukses' => view('admin/setkonten/linkterkait/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatelinkterkait()
    {
        if ($this->request->isAJAX()) {
            $id_link = $this->request->getVar('id_link');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama_link' => [
                    'label' => 'Nama link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'url' => [
                    'label' => 'Alamat URL',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_link'   => $validation->getError('nama_link'),
                        'url'       => $validation->getError('url')
                    ]
                ];
            } else {

                $updatedata = [

                    'nama_link'  => $this->request->getVar('nama_link'),
                    'url'        => $this->request->getVar('url')

                ];

                $this->linkterkait->update($id_link, $updatedata);

                $msg = [
                    'sukses' => 'Data berhasil diubah!'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formgantifoto()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_link');
            $list =  $this->linkterkait->find($id);
            $data = [
                'title'       => 'Ganti Logo',
                'id'          => $list['id_link'],
                'gambar'      => $list['gambar']

            ];
            $msg = [
                'sukses' => view('admin/setkonten/linkterkait/gantifoto', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function douploadLink()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id_link');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'gambar' => [
                    'label' => 'Logo link',
                    'rules' => 'uploaded[gambar]|max_size[gambar,2024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
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
                        'gambar' => $validation->getError('gambar')
                    ]
                ];
            } else {

                //check
                $cekdata = $this->linkterkait->find($id);
                $fotolama = $cekdata['gambar'];

                if ($fotolama != 'url.png' && file_exists('public/img/linkterkait/' . $fotolama)) {
                    unlink('public/img/linkterkait/' . $fotolama);
                }

                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();

                $updatedata = [
                    'gambar' => $nama_file
                ];

                $this->linkterkait->update($id, $updatedata);
                $filegambar->move('public/img/linkterkait/', $nama_file); //folder foto

                $msg = [
                    'sukses' => 'Logo link terkait berhasil diganti!',
                ];
            }
            echo json_encode($msg);
        }
    }
}
