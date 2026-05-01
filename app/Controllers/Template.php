<?php

namespace App\Controllers;

class Template extends BaseController
{

    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();

        $data = [
            'title'       => 'Setting Template ',
            'subtitle'    => $konfigurasi['nama'],

        ];
        return view('admin/pengaturan/template/index', $data);
    }


    public function all()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();

        $data = [
            'title'       => 'Tema Website ',
            'subtitle'    => $konfigurasi['nama'],

        ];
        return view('admin/pengaturan/template/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {

            $id_grup = session()->get('id_grup');
            $url = 'template';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Template Website',
                        'list'      => $this->template->list(),
                        'akses'     => $akses
                    ];
                    $msg = [
                        'data' => view('admin/pengaturan/template/list', $data)
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
                'title' => 'Tambah Template',
            ];
            $msg = [
                'data' => view('admin/pengaturan/template/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpantemplate()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Template',
                    'rules' => 'required|is_unique[template.nama]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'folder' => [
                    'label' => 'Nama Folder',
                    'rules' => 'required|is_unique[template.folder]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'pembuat' => [
                    'label' => 'Harga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'img' => [
                    'label' => 'Cover',
                    'rules' => 'max_size[img,3024]|mime_in[img,image/png,image/jpg,image/jpeg,image/gif]|is_image[img]',
                    'errors' => [
                        // 'uploaded' => 'Silahkan Masukkan Cover',
                        'max_size' => 'Ukuran {field} Maksimal 3024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'    => $validation->getError('nama'),
                        'pembuat'        => $validation->getError('pembuat'),
                        'folder'         => $validation->getError('folder'),
                        'img'         => $validation->getError('img'),
                    ]
                ];
                echo json_encode($msg);
            } else {
                $filegambar = $this->request->getFile('img');
                $nama_file = $filegambar->getRandomName();
                if ($filegambar->GetError() == 4) {
                    $insertdata = [
                        'nama'      => $this->request->getVar('nama'),
                        'pembuat'   => $this->request->getVar('pembuat'),
                        'folder'    => $this->request->getVar('folder'),
                        'ket'       => $this->request->getVar('ket'),
                        'status'    => '0',
                        'id'        => session()->get('id'),
                        'img'       => 'default.png',

                    ];
                    $this->template->insert($insertdata);

                    $msg = [
                        'sukses' => 'Data berhasil disimpan!'
                    ];
                } else {
                    $insertdata = [
                        'nama'      => $this->request->getVar('nama'),
                        'pembuat'   => $this->request->getVar('pembuat'),
                        'folder'    => $this->request->getVar('folder'),
                        'ket'       => $this->request->getVar('ket'),
                        'status'    => '0',
                        'id'        => session()->get('id'),
                        'img'       => $nama_file,

                    ];
                    $this->template->insert($insertdata);

                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->save('public/img/template/' . $nama_file, 70);
                    $msg = [
                        'sukses' => 'Data berhasil disimpan!'
                    ];
                }
                echo json_encode($msg);
            }
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('template_id');

            $cekdata = $this->template->find($id);
            $fotolama = $cekdata['img'];

            if ($fotolama != ''  && file_exists('public/img/template/' . $fotolama)) {
                unlink('public/img/template/' . $fotolama);
            }

            $this->template->delete($id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $template_id = $this->request->getVar('template_id');
            $list =  $this->template->find($template_id);

            $data = [
                'title'         => 'Edit Template',
                'template_id'     => $list['template_id'],
                'nama'           => $list['nama'],
                'pembuat'   => $list['pembuat'],
                'folder'   => $list['folder'],
                'ket'   => $list['ket'],
                'img'   => $list['img'],

            ];
            $msg = [
                'sukses' => view('admin/pengaturan/template/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatetemplate()
    {
        if ($this->request->isAJAX()) {
            $template_id = $this->request->getVar('template_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama' => [
                    'label' => 'Nama Template',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'pembuat' => [
                    'label' => 'Harga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'folder' => [
                    'label' => 'Folder',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'img' => [
                    'label' => 'Gambar',
                    'rules' => 'max_size[img,3024]|mime_in[img,image/png,image/jpg,image/jpeg,image/gif]|is_image[img]',
                    'errors' => [
                        // 'uploaded' => 'Masukkan gambar',
                        'max_size' => 'Ukuran {field} Maksimal 3024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'    => $validation->getError('nama'),
                        'pembuat'        => $validation->getError('pembuat'),
                        'folder'         => $validation->getError('folder'),
                    ]
                ];
            } else {
                $filegambar = $this->request->getFile('img');
                $nama_file = $filegambar->getRandomName();

                if ($filegambar->GetError() == 4) {
                    $updatedata = [
                        'nama'     => $this->request->getVar('nama'),
                        'pembuat'  => $this->request->getVar('pembuat'),
                        'folder'  => $this->request->getVar('folder'),
                        'ket'  => $this->request->getVar('ket'),

                    ];
                    $this->template->update($template_id, $updatedata);
                    $msg = [
                        'sukses' => 'Data berhasil diubah!'
                    ];
                } else {
                    //check
                    $cekdata = $this->template->find($template_id);
                    $fotolama = $cekdata['img'];
                    if ($fotolama != '' && file_exists('public/img/template/' . $fotolama)) {
                        unlink('public/img/template/' . $fotolama);
                    }

                    $updatedata = [
                        'nama'     => $this->request->getVar('nama'),
                        'pembuat'  => $this->request->getVar('pembuat'),
                        'folder'  => $this->request->getVar('folder'),
                        'ket'  => $this->request->getVar('ket'),
                        'img' => $nama_file
                    ];

                    $this->template->update($template_id, $updatedata);

                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->save('public/img/template/' . $nama_file, 65);

                    $msg = [
                        'sukses' => 'Data berhasil diubah!'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    public function toggle()
    {
        if ($this->request->isAJAX()) {
            $template_id = $this->request->getVar('template_id');
            $folder = $this->request->getVar('folder');
            $cari =  $this->template->find($template_id);

            if ($cari['status'] == '1') {
                $list =  $this->template->getaktif($template_id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'status'        => $toggle,
                ];

                $this->template->update($template_id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil nonaktifkan template!'
                ];
            } else {
                $list =  $this->template->getnonaktif($template_id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'status'        => $toggle,
                ];

                if ($folder == 'plus1' || $folder == 'yayasan') {
                    $lebarlogo = '112';
                    $tinggilogo = '121';
                    $verbost = '0';
                    $uptema = [
                        'verbost'       => $verbost,
                        'wllogo'        => $lebarlogo,
                        'hplogo'        => $tinggilogo,
                        'logo'          => 'p1.png',
                    ];
                    $this->konfigurasi->update(1, $uptema);
                }

                if ($folder == 'plus2' || $folder == 'plus3') {
                    $lebarlogo = '375';
                    $tinggilogo = '90';
                    $verbost = '0';
                    $uptema = [
                        'verbost'       => $verbost,
                        'wllogo'        => $lebarlogo,
                        'hplogo'        => $tinggilogo,
                        'logo'          => 'p3.png',
                    ];
                    $this->konfigurasi->update(1, $uptema);
                }

                if ($folder == 'basic') {
                    $lebarlogo = '255';
                    $tinggilogo = '55';
                    $verbost = '0';
                    $uptema = [
                        'verbost'       => $verbost,
                        'wllogo'        => $lebarlogo,
                        'hplogo'        => $tinggilogo,
                        'logo'          => 'bs.png',
                    ];
                    $this->konfigurasi->update(1, $uptema);
                }

                if ($folder == 'desaku' || $folder == 'company') {
                    $lebarlogo = '375';
                    $tinggilogo = '90';
                    $verbost = '1';
                    $uptema = [
                        'verbost'       => $verbost,
                        'wllogo'        => $lebarlogo,
                        'hplogo'        => $tinggilogo,
                        'logo'          => 'p2.png',
                    ];
                    $this->konfigurasi->update(1, $uptema);
                }


                $this->template->resetstatus();
                $this->template->update($template_id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil menerapkan template!'
                ];
            }

            echo json_encode($msg);
        }
    }
}
