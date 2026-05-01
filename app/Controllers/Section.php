<?php

namespace App\Controllers;

class Section extends BaseController
{

    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'           => 'Setting',
            'subtitle'        => 'Section',
        ];

        return view('admin/setkonten/section/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');

            $url = 'section';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Section',
                        'list'      => $this->section->list(),
                        'akses'     => $akses

                    ];
                    $msg = [
                        'data' => view('admin/setkonten/section/list', $data)
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
                'title' => 'Tambah Section',
                'kategoriberita'    => $this->kategori->list(),
                'halaman'           => $this->berita->listhalaman(),
                'modulpublic'       => $this->modulpublic->listaktif(),
            ];
            $msg = [
                'data' => view('admin/setkonten/section/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function uploadfoto()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama_section' => [
                    'label' => 'Nama Section',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'link' => [
                    'label' => 'Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'gambar' => [
                    'label' => 'Gambar section',
                    'rules' => 'uploaded[gambar]|max_size[gambar,1024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar',
                        'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
                        'mime_in'  => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_section'  => $validation->getError('nama_section'),
                        'link'          => $validation->getError('link'),
                        'gambar'        => $validation->getError('gambar')
                    ]
                ];
            } else {

                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();
                $insertdata = [
                    'nama_section'  => $this->request->getVar('nama_section'),
                    'link'          => $this->request->getVar('link'),
                    'linksumber'          => $this->request->getVar('linksumber'),
                    'gambar'        => $nama_file,

                ];

                $this->section->insert($insertdata);
                \Config\Services::image()
                    ->withFile($filegambar)
                    ->fit(300, 300, 'center')
                    ->save('public/img/section/' .  $nama_file, 70);

                // $filegambar->move('public/img/section/', $nama_file); //folder gbr
                $msg = [
                    'sukses' => 'Gambar berhasil diupload!'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $section_id = $this->request->getVar('section_id');
            $list =  $this->section->find($section_id);
            $data = [
                'title'         => 'Edit section',
                'section_id'    => $list['section_id'],
                'nama_section'  => $list['nama_section'],
                'link'          => $list['link'],
                'linksumber'    => $list['linksumber'],
                'gambar'        => $list['gambar'],
                'kategoriberita'    => $this->kategori->list(),
                'halaman'           => $this->berita->listhalaman(),
                'modulpublic'       => $this->modulpublic->listaktif(),
            ];
            $msg = [
                'sukses' => view('admin/setkonten/section/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatesection()
    {
        if ($this->request->isAJAX()) {

            $section_id = $this->request->getVar('section_id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama_section' => [
                    'label' => 'Nama Section',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'gambar' => [
                    'label' => 'Gambar',
                    'rules' => 'max_size[gambar,2024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
                    'errors' => [

                        'max_size' => 'Ukuran {field} Maksimal 2024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ],
                'link' => [
                    'label' => 'Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'gambar' => $validation->getError('gambar'),
                        'link' => $validation->getError('link')

                    ]
                ];
            } else {
                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();
                //jika edit saja
                if ($filegambar->GetError() == 4) {
                    $data = [
                        'nama_section'   => $this->request->getVar('nama_section'),
                        'link'           => $this->request->getVar('link'),
                        'linksumber'     => $this->request->getVar('linksumber'),
                    ];

                    $this->section->update($section_id, $data);
                    $msg = [
                        'sukses' => 'Data berhasil diubah!'
                    ];
                } else {

                    //check
                    $cekdata = $this->section->find($section_id);
                    $fotolama = $cekdata['gambar'];
                    if ($fotolama != 'default.png' && file_exists('public/img/section/' . $fotolama)) {
                        unlink('public/img/section/' . $fotolama);
                    }

                    $updatedata = [
                        'nama_section'   => $this->request->getVar('nama_section'),
                        'link'   => $this->request->getVar('link'),
                        'linksumber'          => $this->request->getVar('linksumber'),
                        'gambar' => $nama_file
                    ];

                    $this->section->update($section_id, $updatedata);

                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->fit(300, 300, 'center')
                        ->save('public/img/section/' .  $nama_file, 70);
                    // $filegambar->move('public/img/section/', $nama_file); //folder foto

                    $msg = [
                        'sukses' => 'section berhasil diganti!'
                    ];
                }

                echo json_encode($msg);
            }
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('section_id');
            //check
            $cekdata = $this->section->find($id);
            $fotolama = $cekdata['gambar'];
            if ($fotolama != 'default.png' && file_exists('public/img/section/' . $fotolama)) {
                unlink('public/img/section/' . $fotolama);
            }
            $this->section->delete($id);
            $msg = [
                'sukses' => 'Data Section berhasil dihapus.'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('section_id');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check gbr
                $cekdata = $this->section->find($id[$i]);
                $fotolama = $cekdata['gambar'];

                if ($fotolama != 'default.png' && file_exists('public/img/section/' . $fotolama)) {
                    unlink('public/img/section/' . $fotolama);
                }

                $this->section->delete($id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata Data section berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }
}
