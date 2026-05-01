<?php

namespace App\Controllers;

class Daftar extends BaseController
{

    //list frontend
    public function index()
    {

        $konfigurasi    = $this->konfigurasi->vkonfig();
        $kategori = $this->kategori->list();
        $agenda = $this->agenda->listagendapage();
        $template = $this->template->tempaktif();
        $pengumuman = $this->pengumuman->listpengumumanpage();
        $data = [
            'title'         => 'Formulir Pendaftaran | ' . $konfigurasi->nama,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'mbidang'       => $this->bidang->list(),

            'beritapopuler' => $this->berita->populer()->paginate(4),
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
            'sitekey'        => $konfigurasi->g_sitekey,
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'folder'        => $template['folder']
        ];
        return view('' . $template['folder'] . '/' . 'content/daftar', $data);
    }

    // daftar publik
    public function simpananggota()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],

                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',

                    ]
                ],

                'jk' => [
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Silahkan pilih {field} !',

                    ]
                ],

                'tgl_lahir' => [
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],

                'no_hp' => [
                    'label' => 'No HP',
                    'rules' => 'required',
                    'errors' => [

                        'required' => '{field} tidak boleh kosong!',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'       => $validation->getError('nama'),
                        'no_hp'       => $validation->getError('no_hp'),
                        'jk'  => $validation->getError('jk'),
                        'alamat'  => $validation->getError('alamat'),
                        'tgl_lahir'  => $validation->getError('tgl_lahir'),
                    ]
                ];
            } else {

                $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();

                $secretkey = $konfigurasi['g_secretkey'];
                $g_sitekey = $konfigurasi['g_sitekey'];
                // gcaptcha
                $recaptchaResponse = trim($this->request->getVar('g-recaptcha-response'));
                $secret = $secretkey;

                if ($secretkey != '' && $g_sitekey != '') {

                    $credential = array(
                        'secret' => $secret,
                        'response' => $recaptchaResponse
                    );

                    $verify = curl_init();
                    curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
                    curl_setopt($verify, CURLOPT_POST, true);
                    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
                    curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($verify);

                    $status = json_decode($response, true);
                    if ($status['success']) {

                        $insertdata = [
                            'nama'          => $this->request->getVar('nama'),
                            'no_hp'         => $this->request->getVar('no_hp'),
                            'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
                            'tgl_lahir'     => date('Y-m-d', strtotime($this->request->getVar('tgl_lahir'))),
                            'jk'            => $this->request->getVar('jk'),
                            'alamat'        => $this->request->getVar('alamat'),
                            'tgl_daftar'    => date('Y-m-d'),
                            'status'        => '0',
                            'dok_ktp'       => '',

                        ];

                        $this->anggota->insert($insertdata);

                        $msg = [
                            'sukses' => 'Formulir Pendaftaran Anda sukses terkirim..!'
                        ];
                    } else {
                        $msg = [
                            'gagal' => 'Gagal Daftar Silahkan periksa Kembali!'
                        ];
                    }
                } else {
                    $insertdata = [
                        'nama'          => $this->request->getVar('nama'),
                        'no_hp'         => $this->request->getVar('no_hp'),
                        'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
                        'tgl_lahir'     => date('Y-m-d', strtotime($this->request->getVar('tgl_lahir'))),
                        'jk'            => $this->request->getVar('jk'),
                        'alamat'        => $this->request->getVar('alamat'),
                        'tgl_daftar'    => date('Y-m-d'),
                        'status'        => '0',
                        'dok_ktp'       => '',

                    ];
                    $this->anggota->insert($insertdata);
                    $msg = [
                        'sukses' => 'Formulir Pendaftaran Anda sukses terkirim..!'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    //back end
    public function list()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'           => 'Daftar',
            'subtitle'        => 'Partisipan',
        ];
        return view('admin/interaksi/anggota/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'daftar/list';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1') {
                    $data = [
                        'title'     => 'Anggota',
                        'list'      => $this->anggota->list(),
                        'akses'     => '1'
                    ];
                    $msg = [
                        'data' => view('admin/interaksi/anggota/list', $data)
                    ];
                } elseif ($akses == '2') {

                    $data = [
                        'title'     => 'Anggota',
                        'list'      => $this->anggota->list(),
                        'akses'     => '2'
                    ];
                    $msg = [
                        'data' => view('admin/interaksi/anggota/list', $data)
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

    public function getdatanew()
    {
        if ($this->request->isAJAX()) {
            $data = [

                'list' => $this->anggota->listkritiknew(),
                'totkritik' => $this->anggota->totkritik()
            ];
            $msg = [
                'data' => view('admin/interaksi/bukutamu/vmenukritik', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function formlihat()
    {
        if ($this->request->isAJAX()) {
            $anggota_id = $this->request->getVar('anggota_id');

            $list =  $this->anggota->find($anggota_id);

            $data = [
                'title'       => 'Detail Anggota',
                'anggota_id' => $list['anggota_id'],
                'nama'        => $list['nama'],
                'tempat_lahir'         => $list['tempat_lahir'],
                'alamat'      => $list['alamat'],
                'tgl_lahir'      => $list['tgl_lahir'],
                'tgl_daftar'      => $list['tgl_daftar'],
                'status'      => $list['status'],
                'no_hp'      => $list['no_hp'],
                'jk'      => $list['jk'],
                'nik'      => $list['nik'],
                'provinsi'      => $list['provinsi'],
                'kab'      => $list['kab'],
                'kec'      => $list['kec'],
                'kel'      => $list['kel'],
                'rtrw'      => $list['rtrw'],
                'pekerjaan'      => $list['pekerjaan'],
                'pendidikan'      => $list['pendidikan'],
                'dok_ktp'      => $list['dok_ktp'],

            ];
            $msg = [
                'sukses' => view('admin/interaksi/anggota/lihat', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $anggota_id = $this->request->getVar('anggota_id');

            $list =  $this->anggota->find($anggota_id);

            $data = [
                'title'       => 'Detail Anggota',
                'anggota_id' => $list['anggota_id'],
                'nama'        => $list['nama'],
                'tempat_lahir'         => $list['tempat_lahir'],
                'alamat'      => $list['alamat'],
                'tgl_lahir'      => $list['tgl_lahir'],
                'tgl_daftar'      => $list['tgl_daftar'],
                'status'      => $list['status'],
                'no_hp'      => $list['no_hp'],
                'jk'      => $list['jk'],
                'nik'      => $list['nik'],
                'provinsi'      => $list['provinsi'],
                'kab'      => $list['kab'],
                'kec'      => $list['kec'],
                'kel'      => $list['kel'],
                'rtrw'      => $list['rtrw'],
                'pekerjaan'      => $list['pekerjaan'],
                'pendidikan'      => $list['pendidikan'],
                'dok_ktp'      => $list['dok_ktp'],

            ];
            $msg = [
                'sukses' => view('admin/interaksi/anggota/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updateanggota()
    {
        if ($this->request->isAJAX()) {
            $anggota_id = $this->request->getVar('anggota_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],

                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',

                    ]
                ],

                'jk' => [
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Silahkan pilih {field} !',

                    ]
                ],

                'tgl_lahir' => [
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],

                'no_hp' => [
                    'label' => 'No HP',
                    'rules' => 'required',
                    'errors' => [

                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'       => $validation->getError('nama'),
                        'no_hp'       => $validation->getError('no_hp'),
                        'jk'  => $validation->getError('jk'),
                        'alamat'  => $validation->getError('alamat'),
                        'tgl_lahir'  => $validation->getError('tgl_lahir'),
                    ]
                ];
            } else {

                $updatedata = [

                    'nama'          => $this->request->getVar('nama'),
                    'no_hp'         => $this->request->getVar('no_hp'),
                    'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
                    'tgl_lahir'     => date('Y-m-d', strtotime($this->request->getVar('tgl_lahir'))),
                    'jk'            => $this->request->getVar('jk'),
                    'alamat'        => $this->request->getVar('alamat'),
                    'nik'           => $this->request->getVar('nik'),
                    'provinsi'      => $this->request->getVar('provinsi'),
                    'kab'          => $this->request->getVar('kab'),
                    'kec'          => $this->request->getVar('kec'),
                    'kel'          => $this->request->getVar('kel'),
                    'rtrw'          => $this->request->getVar('rtrw'),
                    'pekerjaan'     => $this->request->getVar('pekerjaan'),
                    'pendidikan'    => $this->request->getVar('pendidikan'),

                ];

                $this->anggota->update($anggota_id, $updatedata);

                $msg = [
                    'sukses' => 'Data berhasil diubah!'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Data',
            ];
            $msg = [
                'data' => view('admin/interaksi/anggota/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    // daftar admin
    public function simpan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],

                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',

                    ]
                ],

                'jk' => [
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Silahkan pilih {field} !',

                    ]
                ],

                'tgl_lahir' => [
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],

                'no_hp' => [
                    'label' => 'No HP',
                    'rules' => 'required',
                    'errors' => [

                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'dok_ktp' => [
                    'label' => 'File KTP',
                    'rules' => 'max_size[dok_ktp,3024]|mime_in[dok_ktp,image/png,image/jpg,image/jpeg,image/gif]|is_image[dok_ktp]',
                    'errors' => [
                        // 'uploaded' => 'Silahkan Masukkan dok_ktp',
                        'max_size' => 'Ukuran {field} Maksimal 3024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'       => $validation->getError('nama'),
                        'no_hp'       => $validation->getError('no_hp'),
                        'jk'  => $validation->getError('jk'),
                        'alamat'  => $validation->getError('alamat'),
                        'tgl_lahir'  => $validation->getError('tgl_lahir'),
                        'dok_ktp'  => $validation->getError('dok_ktp'),
                    ]
                ];
            } else {

                $filektp = $this->request->getFile('dok_ktp');
                $nama_file = $filektp->getRandomName();
                if ($filektp->GetError() == 4) {
                    $insertdata = [
                        'nama'          => $this->request->getVar('nama'),
                        'no_hp'         => $this->request->getVar('no_hp'),
                        'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
                        'tgl_lahir'     => date('Y-m-d', strtotime($this->request->getVar('tgl_lahir'))),
                        'jk'            => $this->request->getVar('jk'),
                        'alamat'        => $this->request->getVar('alamat'),
                        'tgl_daftar'    => date('Y-m-d'),
                        'status'        => '1',
                        'nik'           => $this->request->getVar('nik'),
                        'provinsi'      => $this->request->getVar('provinsi'),
                        'kab'          => $this->request->getVar('kab'),
                        'kec'          => $this->request->getVar('kec'),
                        'kel'          => $this->request->getVar('kel'),
                        'rtrw'          => $this->request->getVar('rtrw'),
                        'pekerjaan'     => $this->request->getVar('pekerjaan'),
                        'pendidikan'    => $this->request->getVar('pendidikan'),
                        'dok_ktp'       => '',
                    ];
                    $this->anggota->insert($insertdata);

                    $msg = [
                        'sukses' => 'Data berhasil disimpan..!'
                    ];
                } else {
                    $insertdata = [

                        'nama'          => $this->request->getVar('nama'),
                        'no_hp'         => $this->request->getVar('no_hp'),
                        'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
                        'tgl_lahir'     => date('Y-m-d', strtotime($this->request->getVar('tgl_lahir'))),
                        'jk'            => $this->request->getVar('jk'),
                        'alamat'        => $this->request->getVar('alamat'),
                        'tgl_daftar'    => date('Y-m-d'),
                        'status'        => '1',
                        'nik'           => $this->request->getVar('nik'),
                        'provinsi'      => $this->request->getVar('provinsi'),
                        'kab'          => $this->request->getVar('kab'),
                        'kec'          => $this->request->getVar('kec'),
                        'kel'          => $this->request->getVar('kel'),
                        'rtrw'          => $this->request->getVar('rtrw'),
                        'pekerjaan'     => $this->request->getVar('pekerjaan'),
                        'pendidikan'    => $this->request->getVar('pendidikan'),
                        'dok_ktp'       => $nama_file,

                    ];

                    $this->anggota->insert($insertdata);
                    \Config\Services::image()
                        ->withFile($filektp)
                        ->save('public/file/dokumen/' . $nama_file, 70);
                    $msg = [
                        'sukses' => 'Data berhasil disimpan!'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $anggota_id = $this->request->getVar('anggota_id');

            //check
            $cekdata = $this->anggota->find($anggota_id);
            $dokktp = $cekdata['dok_ktp'];

            if ($dokktp != '' && file_exists('public/file/dokumen/' . $dokktp)) {
                unlink('public/file/dokumen/' . $dokktp);
            }

            $this->anggota->delete($anggota_id);
            $msg = [
                'sukses' => 'Data berhasil dihapus!'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $anggota_id = $this->request->getVar('anggota_id');
            $jmldata = count($anggota_id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->anggota->find($anggota_id);
                $dokktp = $cekdata['dok_ktp'];

                if ($dokktp != '' && file_exists('public/file/dokumen/' . $dokktp)) {
                    unlink('public/file/dokumen/' . $dokktp);
                }
                $this->anggota->delete($anggota_id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata data berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    public function toggle()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('anggota_id');
            $cari =  $this->anggota->find($id);

            if ($cari['status'] == '1') {
                $list =  $this->anggota->getaktif($id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'status'        => $toggle,
                ];
                $this->anggota->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil Non Aktifkan!'
                ];
            } else {
                $list =  $this->anggota->getnonaktif($id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'status'        => $toggle,
                ];
                $this->anggota->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil Mengaktifkan!'
                ];
            }

            echo json_encode($msg);
        }
    }

    public function hapusfile()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('anggota_id');
            //check
            $cekdata = $this->anggota->find($id);
            $dokktp = $cekdata['dok_ktp'];

            if ($dokktp != '' && file_exists('public/file/dokumen/' . $dokktp)) {
                unlink('public/file/dokumen/' . $dokktp);
            }

            $updatedata = [
                'dok_ktp'           => ''
            ];

            $this->anggota->update($id, $updatedata);

            $msg = [
                'sukses' => 'Data file KTP sukses Dihapus'
            ];

            echo json_encode($msg);
        }
    }
    // form upload ktp
    public function formuploadfile()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('anggota_id');
            $list =  $this->anggota->find($id);
            $data = [
                'title'       => 'File KTP',
                'id'          => $list['anggota_id'],
                'dok_ktp'   => $list['dok_ktp']
            ];
            $msg = [
                'sukses' => view('admin/interaksi/anggota/uploadfile', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanfilektp()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('anggota_id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'dok_ktp' => [
                    'label' => 'File KTP',
                    'rules' => [
                        'uploaded[dok_ktp]',
                        'mime_in[dok_ktp,image/jpg,image/jpeg,image/gif,image/png,application/pdf,application/doc,application/docx,application/xls,application/xlsx,application/ppt,application/pptx,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                        'max_size[dok_ktp,3024]',
                    ],
                    'errors' => [
                        'uploaded' => 'Silahkan Masukkan file',
                        'max_size' => 'Ukuran {field} Maksimal 3024 KB..!!',
                        'mime_in' => 'Format {field} tidak valid..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'dok_ktp' => $validation->getError('dok_ktp')
                    ]
                ];
            } else {

                //check
                $cekdata = $this->anggota->find($id);
                $filelama = $cekdata['dok_ktp'];

                if ($filelama != '' && file_exists('public/file/dokumen/' . $filelama)) {
                    unlink('public/file/dokumen/' . $filelama);
                }

                $filektp = $this->request->getFile('dok_ktp');
                $nama_file = $filektp->getRandomName();

                $updatedata = [
                    'dok_ktp' => $nama_file
                ];

                $this->anggota->update($id, $updatedata);
                $filektp->move('public/file/dokumen/', $nama_file); //folder foto

                $msg = [
                    'sukses' => 'File KTP berhasil diupload!',
                ];
            }
            echo json_encode($msg);
        }
    }
}
