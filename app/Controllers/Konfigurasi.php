<?php

namespace App\Controllers;

class Konfigurasi extends BaseController
{
    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $id_grup = session()->get('id_grup');
        $url = 'konfigurasi';
        $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

        foreach ($listgrupf as $data) :
            $akses = $data['akses'];
        endforeach;
        // jika temukan maka eksekusi
        if ($listgrupf) {
            # cek akses
            $list =  $this->konfigurasi->orderBy('id_setaplikasi ')->first();
            if ($akses == '1' || $akses == '2') {
                $data = [
                    'title'             => 'Dashboard',
                    'subtitle'          => 'Pengaturan Situs',
                    'konfigurasi'       => $this->konfigurasi->list(),
                    'id_setaplikasi'    => $list['id_setaplikasi'],
                    'nama'              => $list['nama'],
                    'alamat'            => $list['alamat'],
                    'no_telp'           => $list['no_telp'],
                    'google_map'        => $list['google_map'],
                    'kabupaten'         => $list['kabupaten'],
                    'provinsi'          => $list['provinsi'],
                    'website'           => $list['website'],
                    'email'             => $list['email'],
                    'deskripsi'         => $list['deskripsi'],
                    'logo'              => $list['logo'],
                    'sts_sambutan'      => $list['sts_sambutan'],
                    'icon'              => $list['icon'],
                    'link_gmap'         => $list['link_gmap'],
                    'sosmed_fb'         => $list['sosmed_fb'],
                    'sosmed_instagram'  => $list['sosmed_instagram'],
                    'sosmed_twiter'     => $list['sosmed_twiter'],
                    'sosmed_youtube'    => $list['sosmed_youtube'],
                    'kategori_id'       => $list['kategori_id'],
                    'mkategori'         => $this->kategori->list(),
                    'judul_section'     => $list['judul_section'],
                    'sts_section'       => $list['sts_section'],
                    'sts_modal'         => $list['sts_modal'],
                    'sts_rt'            => $list['sts_rt'],
                    'sts_count'         => $list['sts_count'],
                    'wllogo'            => $list['wllogo'],
                    'hplogo'            => $list['hplogo'],
                    'wlbanner'          => $list['wlbanner'],
                    'hpbanner'          => $list['hpbanner'],
                    'sts_regis'         => $list['sts_regis'],
                    'sts_web'           => $list['sts_web'],
                    'sts_posting'       => $list['sts_posting'],
                    'verbost'           => $list['verbost'],
                    'smtp_host'         => $list['smtp_host'],
                    'smtp_username'     => $list['smtp_username'],
                    'smtp_password'     => $list['smtp_password'],
                    'smtp_port'         => $list['smtp_port'],
                    'smtp_pengirim'     => $list['smtp_pengirim'],
                    'smtp_pesanbalas'   => $list['smtp_pesanbalas'],
                    'saveweb'           => session()->get('setweb'),
                    'konek_opd'         => $list['konek_opd'],
                    'id_grup'           => $list['id_grup'],
                    'footer_cms'        => $list['footer_cms'],
                    'listgrup'          => $this->grupuser->listgrups(),
                    'akses'             => $akses,
                    'vercms'            => $list['vercms'],
                    'katamutiara'       => $list['katamutiara'],
                    'tokenwa'           => $list['tokenwa'],
                    'no_waysender'      => $list['no_waysender'],
                    'wa_penerima'       => $list['wa_penerima'],
                    'namasingkat'       => $list['namasingkat'],
                    'urlserver'         => $list['urlserver'],
                    'g_secretkey'       => $list['g_secretkey'],
                    'g_sitekey'         => $list['g_sitekey'],
                    // 'ukuran_upload'     => $list['ukuran_upload'],
                ];
                return view('admin/pengaturan/konfigurasi/konfigurasi', $data);
            } else {

                return redirect()->to(base_url('dasboard'));
            }
        } else {

            return redirect()->to(base_url('dasboard'));
        }
    }

    public function simpankonfig()
    {

        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama website',
                    // 'rules' => 'required|alpha_numeric_space',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        // 'alpha_numeric_space' => 'Tidak boleh mengandung karakter unik',
                    ]
                ],
                'deskripsi' => [
                    'label' => 'Deskripsi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'no_telp' => [
                    'label' => 'no_telp',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'kabupaten' => [
                    'label' => 'kabupaten',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'provinsi' => [
                    'label' => 'provinsi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'website' => [
                    'label' => 'website',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'google_map' => [
                    'label' => 'Google Map',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'link_gmap' => [
                    'label' => 'Link berbagi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'sosmed_fb' => [
                    'label' => 'Facebook',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'sosmed_instagram' => [
                    'label' => 'Instagram',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'sosmed_twiter' => [
                    'label' => 'Twitter',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'sosmed_youtube' => [
                    'label' => 'Youtube',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'judul_section' => [
                    'label' => 'Judul Section',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'wllogo' => [
                    'label' => 'Lebar Logo',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'hplogo' => [
                    'label' => 'Panjang Logo',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'wlbanner' => [
                    'label' => 'Lebar Banner',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'hpbanner' => [
                    'label' => 'Panjang Banner',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                // 'ukuran_upload' => [
                //     'label' => 'Ukuran Upload',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ]
                // ]


            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'        => $validation->getError('nama'),
                        'alamat'      => $validation->getError('alamat'),
                        'no_telp'     => $validation->getError('no_telp'),
                        'google_map'  => $validation->getError('google_map'),
                        'link_gmap'   => $validation->getError('link_gmap'),
                        'kabupaten'   => $validation->getError('kabupaten'),
                        'provinsi'    => $validation->getError('provinsi'),
                        'website'     => $validation->getError('website'),
                        'email'       => $validation->getError('email'),
                        'deskripsi'   => $validation->getError('deskripsi'),
                        'sosmed_fb'   => $validation->getError('sosmed_fb'),
                        'sosmed_instagram'   => $validation->getError('sosmed_instagram'),
                        'sosmed_twiter'   => $validation->getError('sosmed_twiter'),
                        'sosmed_youtube'   => $validation->getError('sosmed_youtube'),
                        'judul_section'   => $validation->getError('judul_section'),
                        'wplogo'   => $validation->getError('wplogo'),
                        'hllogo'   => $validation->getError('hllogo'),
                        'hpbanner'   => $validation->getError('hpbanner'),
                        'wlbanner'   => $validation->getError('wlbanner'),
                        // 'ukuran_upload'   => $validation->getError('ukuran_upload'),

                    ]
                ];
            } else {
                $simpandata = [
                    'nama'          => $this->request->getPost('nama'),
                    'alamat'        => $this->request->getPost('alamat'),
                    'no_telp'       => $this->request->getPost('no_telp'),
                    'kabupaten'     => $this->request->getPost('kabupaten'),
                    'provinsi'      => $this->request->getPost('provinsi'),
                    'website'       => $this->request->getPost('website'),
                    'email'         => $this->request->getPost('email'),
                    'deskripsi'     => $this->request->getPost('deskripsi'),
                    'google_map'    => $this->request->getPost('google_map'),
                    'link_gmap'    => $this->request->getPost('link_gmap'),
                    'sosmed_fb'    => $this->request->getPost('sosmed_fb'),
                    'sosmed_instagram'    => $this->request->getPost('sosmed_instagram'),
                    'sosmed_twiter'    => $this->request->getPost('sosmed_twiter'),
                    'sosmed_youtube'    => $this->request->getPost('sosmed_youtube'),
                    'kategori_id'    => $this->request->getPost('kategori'),
                    'judul_section'    => $this->request->getPost('judul_section'),
                    'sts_section'    => $this->request->getPost('sts_section'),
                    'sts_modal'    => $this->request->getPost('sts_modal'),
                    'sts_rt'    => $this->request->getPost('sts_rt'),
                    'sts_count'    => $this->request->getPost('sts_count'),
                    'wllogo'    => $this->request->getPost('wllogo'),
                    'hplogo'    => $this->request->getPost('hplogo'),
                    'wlbanner'    => $this->request->getPost('wlbanner'),
                    'hpbanner'    => $this->request->getPost('hpbanner'),
                    'sts_regis'    => $this->request->getPost('sts_regis'),
                    'sts_posting'    => $this->request->getPost('sts_posting'),
                    'verbost'    => $this->request->getPost('verbost'),
                    'smtp_host'    => $this->request->getPost('smtp_host'),
                    'smtp_username'    => $this->request->getPost('smtp_username'),
                    'smtp_password'    => $this->request->getPost('smtp_password'),
                    'smtp_port'    => $this->request->getPost('smtp_port'),
                    'smtp_pengirim'    => $this->request->getPost('smtp_pengirim'),
                    'smtp_pesanbalas'    => $this->request->getPost('smtp_pesanbalas'),
                    'konek_opd'    => $this->request->getPost('konek_opd'),
                    'id_grup'       => $this->request->getPost('id_grup'),
                    'footer_cms'        => $this->request->getPost('footer_cms'),
                    'katamutiara'    => $this->request->getPost('katamutiara'),
                    'tokenwa'        => $this->request->getPost('tokenwa'),
                    'no_waysender'    => $this->request->getPost('no_waysender'),
                    'wa_penerima'    => $this->request->getPost('wa_penerima'),
                    'namasingkat'    => $this->request->getPost('namasingkat'),
                    'urlserver'    => $this->request->getPost('urlserver'),
                    'g_secretkey'    => $this->request->getPost('g_secretkey'),
                    'g_sitekey'    => $this->request->getPost('g_sitekey'),
                    'ukuran_upload'    => $this->request->getPost('ukuran_upload'),

                ];
                // $id_setaplikasi  = $this->request->getVar('id_setaplikasi ');
                $this->konfigurasi->update(1, $simpandata);
                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formuploadlogo()
    {
        if ($this->request->isAJAX()) {
            $list =  $this->konfigurasi->orderBy('id_setaplikasi ')->first();
            $data = [
                'title'          => 'Ganti Logo Website',
                'logo'           => $list['logo'],
                'id_setaplikasi' => $list['id_setaplikasi']
            ];
            $msg = [
                'sukses' => view('admin/pengaturan/konfigurasi/uploadlogo', $data)

            ];
            echo json_encode($msg);
        }
    }

    public function douploadlogo()
    {
        if ($this->request->isAJAX()) {

            $id_setaplikasi = $this->request->getVar('id_setaplikasi');
            $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
            $lebar = $konfigurasi['wllogo'];
            $panjang = $konfigurasi['hplogo'];

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'logo' => [
                    'label' => 'Upload Logo',
                    'rules' => 'uploaded[logo]|mime_in[logo,image/png,image/jpg,image/jpeg]|is_image[logo]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar',
                        'mime_in' => 'Harus gambar!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'logo' => $validation->getError('logo')
                    ]
                ];
            } else {

                //check
                $cekdata = $this->konfigurasi->find($id_setaplikasi);
                $fotolama = $cekdata['logo'];
                if ($fotolama != '' && file_exists('public/img/konfigurasi/logo/' . $fotolama)) {
                    unlink('public/img/konfigurasi/logo/' . $fotolama);
                }

                $filegambar = $this->request->getFile('logo');
                $nama_file = $filegambar->getRandomName();
                $updatedata = [
                    'logo'             => $nama_file,
                ];

                $this->konfigurasi->update($id_setaplikasi, $updatedata);

                \Config\Services::image()
                    ->withFile($filegambar)
                    ->fit($lebar, $panjang, 'center')
                    ->save('public/img/konfigurasi/logo/' .  $nama_file);

                $msg = [
                    'sukses' => 'Logo berhasil diupload!',
                ];
            }
            echo json_encode($msg);
        }
    }


    public function formuploadicon()
    {
        if ($this->request->isAJAX()) {
            $id_setaplikasi = $this->request->getVar('id_setaplikasi');
            $list = $this->konfigurasi->find($id_setaplikasi);
            $data = [
                'title' => 'Upload Icon Website',
                'list'  => $list,
                'id_setaplikasi' => $list['id_setaplikasi']
            ];
            $msg = [
                'sukses' => view('admin/pengaturan/konfigurasi/uploadicon', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function douploadicon()
    {
        if ($this->request->isAJAX()) {

            $id_setaplikasi = $this->request->getVar('id_setaplikasi');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'icon' => [
                    'label' => 'Upload Icon',
                    'rules' => 'uploaded[icon]|mime_in[icon,image/png,image/jpg,image/jpeg]|is_image[icon]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar',
                        'mime_in' => 'Harus gambar!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'icon' => $validation->getError('icon')
                    ]
                ];
            } else {

                //check
                $cekdata = $this->konfigurasi->find($id_setaplikasi);
                $fotolama = $cekdata['icon'];
                if ($fotolama != '' && file_exists('public/img/konfigurasi/icon/' . $fotolama)) {
                    unlink('public/img/konfigurasi/icon/' . $fotolama);
                }

                $filegambar = $this->request->getFile('icon');

                $updatedata = [
                    'icon' => $filegambar->getName(),
                ];

                $this->konfigurasi->update($id_setaplikasi, $updatedata);

                $filegambar->move('public/img/konfigurasi/icon/');
                $msg = [
                    'sukses' => 'Gambar berhasil diupload!',
                ];
            }
            echo json_encode($msg);
        }
    }
}
