<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;

class Kritiksaran extends BaseController
{

    //front end
    public function masukansaran()
    {
        $konfigurasi        = $this->konfigurasi->vkonfig();
        $suaraanda = $this->kritiksaran->listsuaraanda();
        $template = $this->template->tempaktif();
        $data = [
            'title'         => 'Masukan & Saran ' . $konfigurasi->nama,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),
            'suaraanda'     => $suaraanda->paginate(4, 'hal'),
            'pager'         => $suaraanda->pager,
            'jum'           => $this->kritiksaran->totsuaraanda(),
            'banner'        => $this->banner->list(),
            'infografis'    => $this->banner->listinfo(),
            'infografis1'   => $this->banner->listinfo1(),
            'kategori'      => $this->kategori->list(),
            'agenda'        => $this->agenda->listagendapage()->paginate(4),
            'pengumuman'    => $this->pengumuman->listpengumumanpage()->paginate(10),
            'beritapopuler' => $this->berita->populer()->paginate(4),
            'section'       => $this->section->list(),
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'sitekey'        => $konfigurasi->g_sitekey,
            'infografis10'    => $this->banner->listinfopage()->paginate(10),

            'folder'        => $template['folder']
        ];
        return view('' . $template['folder'] . '/' . 'content/masukansaran', $data);
    }


    public function formkritik()
    {
        if ($this->request->isAJAX()) {
            $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
            $g_sitekey = $konfigurasi['g_sitekey'];

            $data = [
                'title'       => 'Masukan Saran',
                'konfigurasi' => $konfigurasi,
                'sitekey'     => $g_sitekey,

            ];
            $msg = [

                'data' => view('admin/modal/kritiksaranmd', $data)
            ];
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
            'title'           => 'Masukan',
            'subtitle'        => 'Saran',
        ];
        return view('admin/interaksi/kritiksaran/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');

            $url = 'kritiksaran/list';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Masukan Saran',
                        'list'      => $this->kritiksaran->list(),
                        'akses'     => $akses
                    ];
                    $msg = [
                        'data' => view('admin/interaksi/kritiksaran/list', $data)
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

                'list'      => $this->kritiksaran->listkritiknew(),
                'totkritik' => $this->kritiksaran->totkritik()

            ];
            $msg = [
                'data' => view('admin/interaksi/kritiksaran/vmenukritik', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanKritik()
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

                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'valid_email' => 'Masukkan {field} dengan benar!',
                    ]
                ],
                'judul' => [
                    'label' => 'Topik',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',

                    ]
                ],
                'isi_kritik' => [
                    'label' => 'Isi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'no_hpusr' => [
                    'label' => 'No HP',
                    'rules' => 'required',
                    'errors' => [
                        // 'max_length' => '{field} maksimal 13 karakter!',
                        // 'min_length' => '{field} minimal 13 karakter!',
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'           => $validation->getError('nama'),
                        'email' => $validation->getError('email'),
                        'no_hpusr' => $validation->getError('no_hpusr'),
                        'judul' => $validation->getError('judul'),
                        'isi_kritik' => $validation->getError('isi_kritik'),
                    ]
                ];
            } else {
                $nama = $this->request->getVar('nama');
                $email = $this->request->getVar('email');
                $isi_kritik = $this->request->getVar('isi_kritik');
                $hpuser = $this->request->getVar('no_hpusr');

                $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                $apikey = $konfigurasi['tokenwa']; //nomor wa 165329ea1ff5c5ecbdbbeef
                $phone = $konfigurasi['no_waysender']; //nomor wa gateway
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
                            'nama'         => $nama,
                            'email'        => $email,
                            'judul'        => $this->request->getVar('judul'),
                            'no_hpusr'     => $hpuser,
                            'isi_kritik'   => $isi_kritik,
                            'tanggal'      => date('Y-m-d'),
                            'status'       => '0'

                        ];
                        $this->kritiksaran->insert($insertdata);
                        // $isipesan = '*Pesan dari :* ' . $nama . ' *Isi Pesan :* ' . $isi_kritik . ' _Klik disini untuk balas_ ' . base_url('kritiksararan/list');
                        $isipesan = 'Pesan dari : *' . $nama . '* Isi Pesan : *' . $isi_kritik . '* _[Klik disini untuk balas](' . base_url('kritiksararan/list') . ')';

                        if ($apikey != '' and $phone != '') {
                            $this->kirimWA($isipesan);
                        }
                        $msg = [
                            'sukses' => 'Pesan Anda sukses terkirim..! Tanggapan akan dikirimkan ke Email Anda!'
                        ];
                    } else {
                        $msg = [
                            'gagal' => 'Gagal kirim pesan Silahkan periksa Kembali!'
                        ];
                    }
                } else {


                    $insertdata = [
                        'nama'         => $nama,
                        'email'        => $email,
                        'judul'        => $this->request->getVar('judul'),
                        'no_hpusr'     => $hpuser,
                        'isi_kritik'   => $isi_kritik,
                        'tanggal'      => date('Y-m-d'),
                        'status'       => '0'

                    ];
                    $this->kritiksaran->insert($insertdata);

                    // $isipesan = '*Pesan dari :* ' . $nama . ' *Isi Pesan :* ' . $isi_kritik . ' _Klik disini untuk balas_ ' . base_url('kritiksararan/list');
                    $isipesan = 'Pesan dari : *' . $nama . '* Isi Pesan : *' . $isi_kritik . '* _[Klik disini untuk balas](' . base_url('kritiksararan/list') . ')';

                    if ($apikey != '' and $phone != '') {
                        $this->kirimWA($isipesan);
                    }
                    $msg = [
                        'sukses' => 'Pesan Anda sukses terkirim..! Tanggapan akan dikirimkan ke Email Anda!'
                    ];
                }

                // gunakan google
            }
            echo json_encode($msg);
        }
    }

    function kirimWA($isipesan)
    {

        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
        $apikey = $konfigurasi['tokenwa']; //nomor wa 165329ea1ff5c5ecbdbbeef
        $phone = $konfigurasi['no_waysender']; //nomor wa gateway
        $hpuser = $konfigurasi['wa_penerima']; //nomor wa penerima
        $urlserver = $konfigurasi['urlserver']; //server layanan

        $data = [
            'api_key' => $apikey,
            'sender'  => $phone, //dari Wa gateway
            'number'  => $hpuser, // yg terima wa
            'message' => $isipesan
        ];

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $urlserver,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data)
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        // echo $response;
    }

    // form balas masukan saran
    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $id_grup = session()->get('id_grup');
            $kritiksaran_id = $this->request->getVar('kritiksaran_id');
            $list =  $this->kritiksaran->find($kritiksaran_id);
            $url = 'kritiksaran/list';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'             => 'Detail Kritik Saran',
                        'kritiksaran_id'    => $list['kritiksaran_id'],
                        'nama'              => $list['nama'],
                        'email'             => $list['email'],
                        'judul'             => $list['judul'],
                        'no_hpusr'          => $list['no_hpusr'],
                        'isi_kritik'        => $list['isi_kritik'],
                        'tanggal'           => $list['tanggal'],
                        'status'            => $list['status'],
                        'balas'             => $list['balas'],
                        'akses'             => $akses

                    ];
                    $msg = [
                        'sukses' => view('admin/interaksi/kritiksaran/edit', $data)
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

    public function updatestatus()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'balas' => [
                    'label' => 'Tanggapan/Balasan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'balas' => $validation->getError('balas'),
                    ]
                ];
            } else {
                $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                $balasbuka = $konfigurasi['smtp_pesanbalas']; //email dinas penyamaran
                $apikey = $konfigurasi['tokenwa'];
                $phone = $konfigurasi['no_waysender']; //nomor wa gateway

                $kritiksaran_id = $this->request->getVar('kritiksaran_id');
                $emailusr = $this->request->getVar('email'); //email user
                $nama = $this->request->getVar('nama'); //nama user
                $no_hpusr = $this->request->getVar('no_hpusr');
                $balas = $this->request->getVar('balas'); //isi balasan
                $title = 'Balasan Masukan dan Saran'; //nama email
                $pesanbalas = '<h2> ' . $balasbuka . ' </h2><p> <h4> ' . $balas . '</h4></p>';
                $isibalas = 'Hallo, *' . $nama . '*.. ' . $balasbuka . 'Berikut Jawaban kami.. *' . $balas . '* _Jangan balas pesan ini, karena otomatis dari Sistem_ ' . $konfigurasi['website'];

                $data = [
                    'status'        => '1',
                    'balas'         => $balas,
                    'tgl_bls'      => date('Y-m-d'),
                ];

                $this->kritiksaran->update($kritiksaran_id, $data);
                $this->sendEmail($emailusr, $title, $pesanbalas);

                if ($apikey != '' and $phone != '') {
                    $this->kirimwabalas($isibalas, $no_hpusr);
                }

                $msg = [
                    'sukses' => 'Pesan sukses dibalas & Terkirim ke Email!'
                ];
            }
            echo json_encode($msg);
        }
    }

    function kirimwabalas($isibalas, $no_hpusr)
    {

        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
        $apikey = $konfigurasi['tokenwa']; //nomor wa 165329ea1ff5c5ecbdbbeef
        $phone = $konfigurasi['no_waysender']; //nomor wa gateway
        $urlserver = $konfigurasi['urlserver']; //server layanan

        $data = [
            'api_key' => $apikey,
            'sender'  => $phone, //dari Wa gateway
            'number'  => $no_hpusr, // yg terima wa
            'message' => $isibalas
        ];

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $urlserver,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data)
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        // echo $response;
    }


    private function sendEmail($emailusr, $title, $pesanbalas)
    {
        $email_smtp = \Config\Services::email();
        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
        $namadinas = $konfigurasi['smtp_pengirim']; //nama samar

        $namadomain = $konfigurasi['smtp_host'];
        $smptuser = $konfigurasi['smtp_username'];
        $pass = $konfigurasi['smtp_password'];
        $port = $konfigurasi['smtp_port'];


        $config["protocol"] = "smtp";

        //isi sesuai nama domain/mail server
        $config["SMTPHost"]  = $namadomain;

        //alamat email SMTP
        $config["SMTPUser"]  = $smptuser;

        //password email SMTP
        $config["SMTPPass"]  = $pass;

        $config["SMTPPort"]  = $port;
        $config["SMTPCrypto"] = "ssl";

        $email_smtp->initialize($config);

        $email_smtp->setFrom($smptuser, $namadinas);
        $email_smtp->setTo($emailusr);
        $email_smtp->setSubject($title);
        $email_smtp->setMessage($pesanbalas);

        $email_smtp->send();
    }

    //publish dan unpublish berita
    public function toggle()
    {
        if ($this->request->isAJAX()) {
            $kritiksaran_id = $this->request->getVar('kritiksaran_id');
            $cari =  $this->kritiksaran->find($kritiksaran_id);

            if ($cari['status'] == '2') {
                $list =  $this->kritiksaran->getaktif($kritiksaran_id);
                $toggle = $list ? 1 : 2;
                $updatedata = [
                    'status'        => $toggle,
                ];
                $this->kritiksaran->update($kritiksaran_id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil dinonaktifkan!'
                ];
            } else {
                $list =  $this->kritiksaran->getnonaktif($kritiksaran_id);
                $toggle = $list ? 2 : 1;
                $updatedata = [
                    'status'        => $toggle,
                ];
                $this->kritiksaran->update($kritiksaran_id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil menampilkan ke publik!'
                ];
            }

            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $kritiksaran_id = $this->request->getVar('kritiksaran_id');

            $this->kritiksaran->delete($kritiksaran_id);
            $msg = [
                'sukses' => 'Data berhasil dihapus!'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $kritiksaran_id = $this->request->getVar('kritiksaran_id');
            $jmldata = count($kritiksaran_id);
            for ($i = 0; $i < $jmldata; $i++) {

                $this->kritiksaran->delete($kritiksaran_id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata data berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }
}
