<?php

namespace App\Controllers;

class Bukutamu extends BaseController
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
            'title'         => 'Buku Tamu | ' . $konfigurasi->nama,
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
            'infografis10'    => $this->banner->listinfopage()->paginate(10),
            'folder'        => $template['folder']
        ];
        return view('' . $template['folder'] . '/' . 'content/bukutamu', $data);
    }

    public function simpanbukutamu()
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

                'instansi' => [
                    'label' => 'Instansi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',

                    ]
                ],

                'bidang_id' => [
                    'label' => 'Bidang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Silahkan pilih {field} !',

                    ]
                ],

                'keperluan' => [
                    'label' => 'Keperluan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'telp' => [
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
                        'telp'       => $validation->getError('telp'),
                        'bidang_id'  => $validation->getError('bidang_id'),
                        'instansi'   => $validation->getError('instansi'),
                        'keperluan'  => $validation->getError('keperluan'),
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
                            'nama'         => $this->request->getVar('nama'),
                            'bidang_id'        => $this->request->getVar('bidang_id'),
                            'telp'          => $this->request->getVar('telp'),
                            'instansi'        => $this->request->getVar('instansi'),
                            'keperluan'   => $this->request->getVar('keperluan'),
                            'tanggal'      => date('Y-m-d'),
                            'status'       => '0'

                        ];

                        $this->bukutamu->insert($insertdata);

                        $msg = [
                            'sukses' => 'Pesan Anda sukses terkirim..!'
                        ];
                    } else {
                        $msg = [
                            'gagal' => 'Gagal kirim pesan Silahkan periksa Kembali!'
                        ];
                    }
                } else {
                    $insertdata = [
                        'nama'         => $this->request->getVar('nama'),
                        'bidang_id'        => $this->request->getVar('bidang_id'),
                        'telp'          => $this->request->getVar('telp'),
                        'instansi'        => $this->request->getVar('instansi'),
                        'keperluan'   => $this->request->getVar('keperluan'),
                        'tanggal'      => date('Y-m-d'),
                        'status'       => '0'

                    ];
                    $this->bukutamu->insert($insertdata);
                    $msg = [
                        'sukses' => 'Pesan Anda sukses terkirim..!'
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
            'title'           => 'Buku',
            'subtitle'        => 'Tamu',
        ];
        return view('admin/interaksi/bukutamu/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'bukutamu/list';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1') {
                    $data = [
                        'title'     => 'Buku Tamu',
                        'list'      => $this->bukutamu->list(),
                        'akses'     => '1'
                    ];
                    $msg = [
                        'data' => view('admin/interaksi/bukutamu/list', $data)
                    ];
                } elseif ($akses == '2') {

                    $data = [
                        'title'     => 'Buku Tamu',
                        'list'      => $this->bukutamu->list(),
                        'akses'     => '2'
                    ];
                    $msg = [
                        'data' => view('admin/interaksi/bukutamu/list', $data)
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

                'list' => $this->bukutamu->listkritiknew(),
                'totkritik' => $this->bukutamu->totkritik()
            ];
            $msg = [
                'data' => view('admin/interaksi/bukutamu/vmenukritik', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $bukutamu_id = $this->request->getVar('bukutamu_id');
            $bidang_id = $this->request->getVar('bidang_id');
            $list =  $this->bukutamu->find($bukutamu_id);
            $cari =  $this->bidang->find($bidang_id);

            $data = [
                'title'       => 'Detail Buku Tamu',
                'bukutamu_id' => $list['bukutamu_id'],
                'nama'        => $list['nama'],
                'instansi'         => $list['instansi'],
                'bidang'         => $cari['nama_bidang'],
                'keperluan'      => $list['keperluan'],
                'tanggal'      => $list['tanggal'],
                'status'      => $list['status'],
                'telp'      => $list['telp'],

            ];
            $msg = [
                'sukses' => view('admin/interaksi/bukutamu/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $bukutamu_id = $this->request->getVar('bukutamu_id');

            $this->bukutamu->delete($bukutamu_id);
            $msg = [
                'sukses' => 'Data berhasil dihapus!'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $bukutamu_id = $this->request->getVar('bukutamu_id');
            $jmldata = count($bukutamu_id);
            for ($i = 0; $i < $jmldata; $i++) {

                $this->bukutamu->delete($bukutamu_id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata data berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    // start bidang
    public function bidang()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }

        $data = [
            'title' => 'Master',
            'subtitle'    => 'Bidang',
        ];
        return view('admin/interaksi/bukutamu/bt_bidang/index', $data);
    }

    public function getbidang()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'bukutamu/list';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1') {
                    $data = [
                        'title'     => 'Data Bidang',
                        'list'      => $this->bidang->list(),
                        'akses'     => 1
                    ];
                    $msg = [
                        'data' => view('admin/interaksi/bukutamu/bt_bidang/list', $data)
                    ];
                } elseif ($akses == '2') {

                    $data = [
                        'title'     => 'Data Bidang',
                        'list'      => $this->bidang->list(),
                        'akses'     => 2
                    ];
                    $msg = [
                        'data' => view('admin/interaksi/bukutamu/bt_bidang/list', $data)
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

    public function formbidang()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Bidang'
            ];
            $msg = [
                'data' => view('admin/interaksi/bukutamu/bt_bidang/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanbidang()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_bidang' => [
                    'label' => 'Bidang',
                    'rules' => 'required|is_unique[bt_bidang.nama_bidang]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_bidang' => $validation->getError('nama_bidang'),
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_bidang' => $this->request->getVar('nama_bidang'),
                    // 'slug_kategori' => $this->request->getVar('slug_kategori'),
                ];

                $this->bidang->insert($simpandata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditbidang()
    {
        if ($this->request->isAJAX()) {
            $bidang_id = $this->request->getVar('bidang_id');
            $list =  $this->bidang->find($bidang_id);
            $data = [
                'title'           => 'Edit Bidang',
                'bidang_id'     => $list['bidang_id'],
                'nama_bidang'   => $list['nama_bidang'],
            ];
            $msg = [
                'sukses' => view('admin/interaksi/bukutamu/bt_bidang/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatebidang()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_bidang' => [
                    'label' => 'Nama Bidang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_bidang' => $validation->getError('nama_bidang'),
                    ]
                ];
            } else {
                $updatedata = [
                    'nama_bidang' => $this->request->getVar('nama_bidang'),
                    // 'slug_kategori' => $this->request->getVar('slug_kategori'),
                ];

                $bidang_id = $this->request->getVar('bidang_id');
                $this->bidang->update($bidang_id, $updatedata);

                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapusbidang()
    {
        if ($this->request->isAJAX()) {
            $bidang_id = $this->request->getVar('bidang_id');
            $this->bidang->delete($bidang_id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }
}
