<?php

namespace App\Controllers;

class Iklan extends BaseController
{

    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'        => 'Setting',
            'subtitle'     => 'Iklan',

        ];

        return view('admin/setkonten/iklan/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'iklan';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Iklan',
                        'list'      => $this->banner->listiklan(),
                        'akses'     => $akses

                    ];
                    $msg = [
                        'data' => view('admin/setkonten/iklan/list', $data)
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
                'title'         => 'Tambah Iklan',
                'kategori'      => $this->kategori->list(),
                'halaman'       => $this->berita->listhalaman(),
                'modulpublic'   => $this->modulpublic->listaktif(),

            ];
            $msg = [
                'data' => view('admin/setkonten/iklan/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function uploadfoto()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'ket' => [
                    'label' => 'Keterangan Iklan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'banner_image' => [
                    'label' => 'Gambar Iklan',
                    'rules' => 'uploaded[banner_image]|max_size[banner_image,2024]|mime_in[banner_image,image/png,image/jpg,image/jpeg,image/gif]|is_image[banner_image]',
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
                        'ket'           => $validation->getError('ket'),
                        'banner_image'  => $validation->getError('banner_image')
                    ]
                ];
            } else {
                // $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                // $lebar = $konfigurasi['wlbanner'];
                // $panjang = $konfigurasi['hpbanner'];

                $filegambar = $this->request->getFile('banner_image');
                $nama_file = $filegambar->getRandomName();
                $insertdata = [
                    'ket'           => $this->request->getVar('ket'),
                    'link'          => $this->request->getVar('link'),
                    'posisi'        => $this->request->getVar('posisi'),
                    'banner_image'  => $nama_file,
                    'type'          => '2'
                ];

                $this->banner->insert($insertdata);

                \Config\Services::image()
                    ->withFile($filegambar)
                    // ->fit($lebar, $panjang, 'center')
                    ->save('public/img/banner/' .  $nama_file, 70);

                $msg = [
                    'sukses' => 'Iklan berhasil diupload!'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $id_banner = $this->request->getVar('id_banner');
            $list =  $this->banner->find($id_banner);
            $data = [
                'title'             => 'Edit Iklan',
                'id_banner'         => $list['id_banner'],
                'ket'               => $list['ket'],
                'link'              => $list['link'],
                'banner'            => $list['banner_image'],
                'posisi'            => $list['posisi'],
                'kategori'          => $this->kategori->list(),
                'halaman'           => $this->berita->listhalaman(),
                'modulpublic'       => $this->modulpublic->listaktif(),
            ];
            $msg = [
                'sukses' => view('admin/setkonten/iklan/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatebanner()
    {
        if ($this->request->isAJAX()) {

            $id_banner = $this->request->getVar('id_banner');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'ket' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'ket' => $validation->getError('ket'),

                    ]
                ];
                echo json_encode($msg);
            } else {

                $data = [
                    'ket'   => $this->request->getVar('ket'),
                    'link'   => $this->request->getVar('link'),
                    'posisi'   => $this->request->getVar('posisi'),
                ];

                $this->banner->update($id_banner, $data);
                $msg = [
                    'sukses' => 'Data berhasil diubah!'
                ];


                echo json_encode($msg);
            }
        }
    }

    public function formgantibanner()
    {
        if ($this->request->isAJAX()) {
            $id_banner = $this->request->getVar('id_banner');
            $list =  $this->banner->find($id_banner);
            $data = [
                'title'       => 'Ganti Iklan',
                'id_banner'   => $list['id_banner'],

                'banner_image'      => $list['banner_image']
            ];
            $msg = [
                'sukses' => view('admin/setkonten/iklan/gantibanner', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function douploadbanner()
    {
        if ($this->request->isAJAX()) {


            $id_banner = $this->request->getVar('id_banner');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'banner_image' => [
                    'label' => 'Upload Iklan',
                    'rules' => 'uploaded[banner_image]|mime_in[banner_image,image/png,image/jpg,image/jpeg]|is_image[banner_image]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar',
                        'mime_in' => 'Harus gambar!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'banner_image' => $validation->getError('banner_image')
                    ]
                ];
            } else {

                //check
                // $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                // $lebar = $konfigurasi['wlbanner'];
                // $panjang = $konfigurasi['hpbanner'];

                $cekdata = $this->banner->find($id_banner);
                $fotolama = $cekdata['banner_image'];
                if ($fotolama != '' && file_exists('public/img/banner/' . $fotolama)) {
                    unlink('public/img/banner/' . $fotolama);
                }

                $filegambar = $this->request->getFile('banner_image');
                $nama_file = $filegambar->getRandomName();
                $updatedata = [
                    'banner_image'             => $nama_file,
                ];

                $this->banner->update($id_banner, $updatedata);

                \Config\Services::image()
                    ->withFile($filegambar)
                    // ->fit($lebar, $panjang, 'center')
                    ->save('public/img/banner/' .  $nama_file, 70);

                $msg = [
                    'sukses' => 'Iklan berhasil diganti!',
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id_banner = $this->request->getVar('id_banner');
            //check
            $cekdata = $this->banner->find($id_banner);
            $fotolama = $cekdata['banner_image'];
            if ($fotolama != '' && file_exists('public/img/banner/' . $fotolama)) {
                unlink('public/img/banner/' . $fotolama);
            }
            $this->banner->delete($id_banner);
            $msg = [
                'sukses' => 'Data berhasil dihapus!'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $id_banner = $this->request->getVar('id_banner');
            $jmldata = count($id_banner);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->banner->find($id_banner[$i]);
                $fotolama = $cekdata['banner_image'];
                if ($fotolama != '' && file_exists('public/img/banner/' . $fotolama)) {
                    unlink('public/img/banner/' . $fotolama);
                }

                $this->banner->delete($id_banner[$i]);
            }
            $msg = [
                'sukses' => "$jmldata Iklan berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }
}
