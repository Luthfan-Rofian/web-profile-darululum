<?php

namespace App\Controllers;

use PHPExcel;
use PHPExcel_IOFactory;

use CodeIgniter\HTTP\RequestInterface;

class Pegawai extends BaseController
{
    //list semua pegawai frontend
    public function index()
    {
        $konfigurasi    = $this->konfigurasi->vkonfig();
        $kategori       = $this->kategori->list();
        $agenda         = $this->agenda->listagendapage();
        $pegawai        = $this->pegawai->listpegawaipage();
        $pengumuman     = $this->pengumuman->listpengumumanpage();
        $template       = $this->template->tempaktif();
        $data = [
            'title'         => 'Data Pegawai | ' . $konfigurasi->nama,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'pegawai'       => $pegawai->paginate(4, 'hal'),
            'pager'         => $pegawai->pager,
            'jum'           => $this->pegawai->totpegawai(),
            'beritapopuler' => $this->berita->populer()->paginate(8),
            'populer6'      => $this->berita->populer()->paginate(6),
            'kategori'      => $kategori,
            'banner'        => $this->banner->list(),
            'infografis'    => $this->banner->listinfo(),
            'pengumuman'    => $pengumuman->paginate(2),
            'agenda'        => $agenda->paginate(4),
            'infografis1'   => $this->banner->listinfo1(),
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),
            'section'       => $this->section->list(),
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'folder'        => $template['folder']
        ];
        return view('' . $template['folder'] . '/' . 'content/semua_pegawai', $data);
    }


    public function all()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'        => 'Profil',
            'subtitle'    => 'Pegawai',

        ];
        return view('admin/lembaga/pegawai/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {

            $id_grup = session()->get('id_grup');
            $url = 'pegawai/all';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Pegawai',
                        'list'      => $this->pegawai->list(),
                        'akses'     => $akses
                    ];
                    $msg = [
                        'data' => view('admin/lembaga/pegawai/list', $data)
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
        }
        echo json_encode($msg);
    }


    public function formimport()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Import Pegawai',
            ];
            $msg = [
                'data' => view('admin/lembaga/pegawai/formimport', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function prosesExcel()
    {
        $file = $this->request->getFile('fileexcel');
        if ($file != '') {
            new PHPExcel();
            //lokasi file
            $fileLocation = $file->getTempName();
            //baca file
            $objPHPExcel = PHPExcel_IOFactory::load($fileLocation);
            //ambil sheet active
            $sheet    = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true, true, true, true, true, true);
            //looping untuk mengambil data
            foreach ($sheet as $idx => $data) {
                //skip index 1 karena title excel
                if ($idx == 1) {
                    continue;
                }

                $nip = $this->pegawai->cekdata($data['B']);
                if ($nip) {
                    if ($data['B'] == $nip['nip']) {
                        continue;
                    }
                    if ($data['B'] == '') {
                        continue;
                    }
                }

                $nama         = $data['A'];
                $nip          = $data['B'];
                $tempat_lahir = $data['C'];
                $tgl_lahir    = $data['D'];
                $jk           = $data['E'];
                $agama        = $data['F'];
                $pangkat      = $data['G'];
                $jabatan      = $data['H'];

                // insert data
                $this->pegawai->insert([

                    'nama'          => $nama,
                    'nip'           => $nip,
                    'tempat_lahir'  => $tempat_lahir,
                    'tgl_lahir'     => date('Y-m-d', strtotime($tgl_lahir)),
                    'jk'            => $jk,
                    'agama'         => $agama,
                    'pangkat'       => $pangkat,
                    'jabatan'       => $jabatan,
                    'gambar'        => 'default.png',
                ]);
            }
            $msg = [
                'sukses' => 'Data Pegawai berhasil di import!'
            ];
        } else {
            $msg = [
                'kosong' => 'File belum ada!'
            ];
        }
        echo json_encode($msg);
    }

    // END IMPORT

    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Pegawai',
            ];
            $msg = [
                'data' => view('admin/lembaga/pegawai/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanPegawai()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Pegawai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],

                'nip' => [
                    'label' => 'NIP / NO Peg',
                    'rules' => 'required|is_unique[pegawai.nip]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],

                'tempat_lahir' => [
                    'label' => 'Tempat Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'tgl_lahir' => [
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'jk' => [
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'agama' => [
                    'label' => 'Agama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'pangkat' => [
                    'label' => 'Pangkat/Golongan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jabatan' => [
                    'label' => 'Jabatan',
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
                        'nip'           => $validation->getError('nip'),
                        'tempat_lahir'  => $validation->getError('tempat_lahir'),
                        'tgl_lahir'  => $validation->getError('tgl_lahir'),
                        'jk'  => $validation->getError('jk'),
                        'agama'  => $validation->getError('agama'),
                        'pangkat'  => $validation->getError('pangkat'),
                        'jabatan'  => $validation->getError('jabatan'),
                        'gambar'       => $validation->getError('gambar'),

                    ]
                ];
                echo json_encode($msg);
            } else {

                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();
                //jika gambar tidak ada
                if ($filegambar->GetError() == 4) {

                    $insertdata = [
                        'nama'  => $this->request->getVar('nama'),
                        'nip'   => $this->request->getVar('nip'),
                        'tempat_lahir'   => $this->request->getVar('tempat_lahir'),
                        'tgl_lahir'    => date('Y-m-d', strtotime($this->request->getVar('tgl_lahir'))),
                        'jk'   => $this->request->getVar('jk'),
                        'agama'   => $this->request->getVar('agama'),
                        'pangkat'   => $this->request->getVar('pangkat'),
                        'jabatan'   => $this->request->getVar('jabatan'),
                        'gambar'        => 'default.png',
                        'publikasi'   => $this->request->getVar('publikasi'),
                        'penelitian'   => $this->request->getVar('penelitian'),
                        'pengabdian'   => $this->request->getVar('pengabdian'),
                        'asal_s1'   => $this->request->getVar('asal_s1'),
                        'asal_s2'   => $this->request->getVar('asal_s2'),
                        'asal_s3'   => $this->request->getVar('asal_s3'),
                        'bidang_pakar'   => $this->request->getVar('bidang_pakar'),
                        'bio_singkat'   => $this->request->getVar('bio_singkat'),

                    ];
                    $this->pegawai->insert($insertdata);
                    $msg = [
                        'sukses' => 'Pegawai berhasil disimpan!'
                    ];
                } else {

                    $insertdata = [
                        'nama'          => $this->request->getVar('nama'),
                        'nip'           => $this->request->getVar('nip'),
                        'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
                        'tgl_lahir'     => date('Y-m-d', strtotime($this->request->getVar('tgl_lahir'))),
                        'jk'            => $this->request->getVar('jk'),
                        'agama'         => $this->request->getVar('agama'),
                        'pangkat'       => $this->request->getVar('pangkat'),
                        'jabatan'       => $this->request->getVar('jabatan'),
                        'gambar'        => $nama_file,
                        'publikasi'     => $this->request->getVar('publikasi'),
                        'penelitian'    => $this->request->getVar('penelitian'),
                        'pengabdian'    => $this->request->getVar('pengabdian'),
                        'asal_s1'       => $this->request->getVar('asal_s1'),
                        'asal_s2'       => $this->request->getVar('asal_s2'),
                        'asal_s3'       => $this->request->getVar('asal_s3'),
                        'bidang_pakar'  => $this->request->getVar('bidang_pakar'),
                        'bio_singkat'   => $this->request->getVar('bio_singkat'),

                    ];

                    $this->pegawai->insert($insertdata);

                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->fit(283, 360, 'center')
                        ->save('public/img/informasi/pegawai/' .  $nama_file, 70);
                    $msg = [
                        'sukses' => 'Pegawai berhasil disimpan!'
                    ];
                }
                echo json_encode($msg);
            }
        }
    }

    // tupoksi


    // gnti pdf
    public function formgantitupoksi()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('pegawai_id');
            $list =  $this->pegawai->find($id);
            $data = [
                'title'       => 'Upload Tupoksi',
                'id'          => $list['pegawai_id'],
                'filetupoksi'   => $list['filetupoksi']

            ];
            $msg = [
                'sukses' => view('admin/lembaga/pegawai/gantitupoksi', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function douploadtupoksi()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('pegawai_id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'filetupoksi' => [
                    'label' => 'File PDF',
                    'rules' => [
                        'uploaded[filetupoksi]',
                        'mime_in[filetupoksi,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                        'max_size[filetupoksi,5096]',
                    ],
                    'errors' => [
                        'uploaded' => 'Silahkan Masukkan file',
                        'max_size' => 'Ukuran {field} Maksimal 5096 KB..!!',
                        'mime_in' => 'Format file harus PDF..!!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'filetupoksi' => $validation->getError('filetupoksi')
                    ]
                ];
            } else {

                //check
                $cekdata = $this->pegawai->find($id);
                $pdflama = $cekdata['filetupoksi'];

                if ($pdflama != '' && file_exists('public/img/informasi/pegawai/' . $pdflama)) {
                    unlink('public/img/informasi/pegawai/' . $pdflama);
                }

                $filetupoksi = $this->request->getFile('filetupoksi');
                $nama_file = $filetupoksi->getRandomName();

                $updatedata = [
                    'filetupoksi' => $nama_file
                ];

                $this->pegawai->update($id, $updatedata);
                $filetupoksi->move('public/img/informasi/pegawai/', $nama_file);

                $msg = [
                    'sukses' => 'File berhasil diupdate!',
                ];
            }
            echo json_encode($msg);
        }
    }


    public function hapuspdf()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('pegawai_id');
            //check
            $cekdata = $this->pegawai->find($id);
            $pdflama = $cekdata['filetupoksi'];

            if ($pdflama != ''  && file_exists('public/img/informasi/pegawai/' . $pdflama)) {

                unlink('public/img/informasi/pegawai/' . $pdflama);
            }

            $updatedata = [
                'filetupoksi'           => null
            ];

            $this->pegawai->update($id, $updatedata);

            $msg = [
                'sukses' => 'Data tupoksi sukses Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('pegawai_id');
            //check
            $cekdata = $this->pegawai->find($id);
            $fotolama = $cekdata['gambar'];
            $pdflama = $cekdata['filetupoksi'];

            if ($pdflama != ''  && file_exists('public/img/informasi/pegawai/' . $pdflama)) {
                unlink('public/img/informasi/pegawai/' . $pdflama);
            }

            if ($fotolama != 'default.png'  && file_exists('public/img/informasi/pegawai/' . $fotolama)) {
                unlink('public/img/informasi/pegawai/' . $fotolama);
            }

            $this->pegawai->delete($id);
            $msg = [
                'sukses' => 'Data Pegawai Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('pegawai_id');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check gbr
                $cekdata = $this->pegawai->find($id[$i]);
                $pdflama = $cekdata['filetupoksi'];
                $fotolama = $cekdata['gambar'];

                if ($pdflama != ''  && file_exists('public/img/informasi/pegawai/' . $pdflama)) {
                    unlink('public/img/informasi/pegawai/' . $pdflama);
                }

                if ($fotolama != 'default.png'  && file_exists('public/img/informasi/pegawai/' . $fotolama)) {
                    unlink('public/img/informasi/pegawai/' . $fotolama);
                }


                $this->pegawai->delete($id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata Data pegawai berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $pegawai_id = $this->request->getVar('pegawai_id');
            $list =  $this->pegawai->find($pegawai_id);

            $data = [
                'title'          => 'Edit Pegawai',
                'pegawai_id'     => $list['pegawai_id'],
                'nama'           => $list['nama'],
                'nip'           => $list['nip'],
                'tempat_lahir'  => $list['tempat_lahir'],
                'tgl_lahir'     => $list['tgl_lahir'],
                'jk'            => $list['jk'],
                'agama'        => $list['agama'],
                'pangkat'      => $list['pangkat'],
                'jabatan'      => $list['jabatan'],
                'publikasi'  => $list['publikasi'],
                'penelitian'  => $list['penelitian'],
                'pengabdian'  => $list['pengabdian'],
                'asal_s1'  => $list['asal_s1'],
                'asal_s2'  => $list['asal_s2'],
                'asal_s3'  => $list['asal_s3'],
                'bidang_pakar'  => $list['bidang_pakar'],
                'bio_singkat'  => $list['bio_singkat'],


            ];
            $msg = [
                'sukses' => view('admin/lembaga/pegawai/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatepegawai()
    {
        if ($this->request->isAJAX()) {
            $pegawai_id = $this->request->getVar('pegawai_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama' => [
                    'label' => 'Nama Pegawai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],

                'nip' => [
                    'label' => 'NIP / NO Peg',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],

                'tempat_lahir' => [
                    'label' => 'Tempat Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'tgl_lahir' => [
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'jk' => [
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'agama' => [
                    'label' => 'Agama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'pangkat' => [
                    'label' => 'Pangkat/Golongan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jabatan' => [
                    'label' => 'Jabatan',
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
                        'nip'           => $validation->getError('nip'),
                        'tempat_lahir'  => $validation->getError('tempat_lahir'),
                        'tgl_lahir'  => $validation->getError('tgl_lahir'),
                        'jk'  => $validation->getError('jk'),
                        'agama'  => $validation->getError('agama'),
                        'pangkat'  => $validation->getError('pangkat'),
                        'jabatan'  => $validation->getError('jabatan'),
                    ]
                ];
            } else {

                $updatedata = [
                    'nama'  => $this->request->getVar('nama'),
                    'nip'   => $this->request->getVar('nip'),
                    'tempat_lahir'   => $this->request->getVar('tempat_lahir'),
                    'tgl_lahir'    => date('Y-m-d', strtotime($this->request->getVar('tgl_lahir'))),
                    'jk'   => $this->request->getVar('jk'),
                    'agama'   => $this->request->getVar('agama'),
                    'pangkat'   => $this->request->getVar('pangkat'),
                    'jabatan'   => $this->request->getVar('jabatan'),
                    'publikasi'   => $this->request->getVar('publikasi'),
                    'penelitian'   => $this->request->getVar('penelitian'),
                    'pengabdian'   => $this->request->getVar('pengabdian'),
                    'asal_s1'   => $this->request->getVar('asal_s1'),
                    'asal_s2'   => $this->request->getVar('asal_s2'),
                    'asal_s3'   => $this->request->getVar('asal_s3'),
                    'bidang_pakar'   => $this->request->getVar('bidang_pakar'),
                    'bio_singkat'   => $this->request->getVar('bio_singkat'),
                ];
                $this->pegawai->update($pegawai_id, $updatedata);
                $msg = [
                    'sukses' => 'Data Pegawai berhasil diubah!'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formgantifoto()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('pegawai_id');
            $list =  $this->pegawai->find($id);
            $data = [
                'title'       => 'Ganti Foto Pegawai',
                'id'          => $list['pegawai_id'],
                'gambar'   => $list['gambar']
            ];
            $msg = [
                'sukses' => view('admin/lembaga/pegawai/gantifoto', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function douploadfoto()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('pegawai_id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'gambar' => [
                    'label' => 'Foto pegawai',
                    'rules' => 'uploaded[gambar]|max_size[gambar,1024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar',
                        'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
                        'mime_in' => 'Format {field} PNG, Jpeg, Jpg, atau Gif..!!'
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
                $cekdata = $this->pegawai->find($id);
                $fotolama = $cekdata['gambar'];


                if ($fotolama != 'default.png'  && file_exists('public/img/informasi/pegawai/' . $fotolama)) {
                    unlink('public/img/informasi/pegawai/' . $fotolama);
                }

                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();

                $updatedata = [
                    'gambar' => $nama_file
                ];

                $this->pegawai->update($id, $updatedata);
                // $filegambar->move('public/img/informasi/pegawai/', $nama_file); //folder foto
                \Config\Services::image()
                    ->withFile($filegambar)
                    ->fit(283, 350, 'center')
                    ->save('public/img/informasi/pegawai/' .  $nama_file, 70);

                $msg = [
                    'sukses' => 'Foto berhasil diganti!',
                ];
            }
            echo json_encode($msg);
        }
    }
    // lihat frontend
    public function formlihat()
    {
        if ($this->request->isAJAX()) {
            $pegawai_id = $this->request->getVar('pegawai_id');
            $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
            $list =  $this->pegawai->find($pegawai_id);
            $template = $this->template->tempaktif();
            $data = [
                'title'         => 'Detail Pegawai',
                'pegawai_id'    => $list['pegawai_id'],
                'nama'          => $list['nama'],
                'nip'           => $list['nip'],
                'tempat_lahir'  => $list['tempat_lahir'],
                'tgl_lahir'     => $list['tgl_lahir'],
                'jk'            => $list['jk'],
                'agama'         => $list['agama'],
                'pangkat'       => $list['pangkat'],
                'jabatan'       => $list['jabatan'],
                'gambar'        => $list['gambar'],
                'filetupoksi'  => $list['filetupoksi'],
                'publikasi'  => $list['publikasi'],
                'penelitian'  => $list['penelitian'],
                'pengabdian'  => $list['pengabdian'],
                'asal_s1'  => $list['asal_s1'],
                'asal_s2'  => $list['asal_s2'],
                'asal_s3'  => $list['asal_s3'],
                'bidang_pakar'  => $list['bidang_pakar'],
                'bio_singkat'  => $list['bio_singkat'],
                'konfigurasi'  => $konfigurasi,
                'folder'        => $template['folder']

            ];
            $msg = [
                // 'sukses' => view('admin/lembaga/pegawai/lihatpegawaiasli', $data)
                'sukses' => view('admin/lembaga/pegawai/lihatpegawai', $data)
            ];
            echo json_encode($msg);
        }
    }
    public function formlihatback()
    {
        if ($this->request->isAJAX()) {
            $pegawai_id = $this->request->getVar('pegawai_id');
            $list =  $this->pegawai->find($pegawai_id);
            $template = $this->template->tempaktif();
            $data = [
                'title'         => 'Detail Pegawai',
                'pegawai_id'    => $list['pegawai_id'],
                'nama'          => $list['nama'],
                'nip'           => $list['nip'],
                'tempat_lahir'  => $list['tempat_lahir'],
                'tgl_lahir'     => $list['tgl_lahir'],
                'jk'            => $list['jk'],
                'agama'         => $list['agama'],
                'pangkat'       => $list['pangkat'],
                'jabatan'       => $list['jabatan'],
                'gambar'        => $list['gambar'],
                'filetupoksi'  => $list['filetupoksi'],
                'publikasi'  => $list['publikasi'],
                'penelitian'  => $list['penelitian'],
                'pengabdian'  => $list['pengabdian'],
                'asal_s1'  => $list['asal_s1'],
                'asal_s2'  => $list['asal_s2'],
                'asal_s3'  => $list['asal_s3'],
                'bidang_pakar'  => $list['bidang_pakar'],
                'bio_singkat'  => $list['bio_singkat'],
                'folder'        => $template['folder']

            ];
            $msg = [
                'sukses' => view('admin/lembaga/pegawai/lihatpegawaiback', $data)
                // 'sukses' => view('admin/lembaga/pegawai/lihatpegawai', $data)
            ];
            echo json_encode($msg);
        }
    }
}
