<?php

namespace App\Controllers;

class Survey extends BaseController
{

    public function index()
    {

        $konfigurasi    = $this->konfigurasi->vkonfig();
        $kategori = $this->kategori->list();
        $agenda = $this->agenda->listagendapage();
        $surveytopik = $this->surveytopik->listsurveytopikpg();
        $pengumuman = $this->pengumuman->listpengumumanpage();
        $template = $this->template->tempaktif();
        $data = [
            'title'         => 'Survei | ' . $konfigurasi->nama,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'surveytopik'   => $surveytopik->paginate(1, 'hal'),
            'pager'         => $surveytopik->pager,
            'jum'           => $this->surveytopik->totsurvey(),
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
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'infografis10'    => $this->banner->listinfopage()->paginate(10),
            'kategori'      => $this->kategori->list(),
            'sitekey'        => $konfigurasi->g_sitekey,
            'folder'        => $template['folder']

        ];
        return view('' . $template['folder'] . '/' . 'content/survei', $data);
    }


    public function cetak($survey_id = null)
    {

        if ($survey_id == '') {

            return redirect()->to(base_url('surveytopik/all'));
        }

        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
        $surveytopik = $this->surveytopik->listcetak($survey_id);

        $data = [
            'title'     => 'Masukan dan Saran',
            'subtitle'  => 'Detail',
            'konfigurasi'   => $konfigurasi,
            'survey_id' => $survey_id,
            'surveytopik' => $surveytopik,
            'nama_survey' => $surveytopik['nama_survey'],


        ];
        return view('admin/interaksi/surveytopik/cetaksurvey', $data);
    }


    public function all()
    {
        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();

        $data = [
            'title'       => 'Survei ',
            'subtitle'    => $konfigurasi['nama'],

        ];
        return view('admin/interaksi/surveytopik/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {

            $id_grup = session()->get('id_grup');
            $id = session()->get('id');
            $url = 'survey/all';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1') {
                    $data = [
                        'title'     => 'Survei',
                        'list'      => $this->surveytopik->listsurveytopik(),
                        'akses'     => '1'
                    ];
                    $msg = [
                        'data' => view('admin/interaksi/surveytopik/list', $data)
                    ];
                } elseif ($akses == '2') {

                    $data = [
                        'title'     => 'Survei',
                        'list'      => $this->surveytopik->listsurveytopikauthor($id),
                        'akses'     => '2'
                    ];
                    $msg = [
                        'data' => view('admin/interaksi/surveytopik/list', $data)
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


    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Topik',
            ];
            $msg = [
                'data' => view('admin/interaksi/surveytopik/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpansurveytopik()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama_survey' => [
                    'label' => 'Topik Survei',
                    'rules' => 'required|is_unique[survey_topik.nama_survey]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'ket_stb' => [
                    'label' => 'Keterangan stb',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ket_kb' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ket_b' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ket_sb' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_survey'    => $validation->getError('nama_survey'),
                        'ket_stb'        => $validation->getError('ket_stb'),
                        'ket_kb'         => $validation->getError('ket_kb'),
                        'ket_b'          => $validation->getError('ket_b'),
                        'ket_sb'         => $validation->getError('ket_sb'),
                    ]
                ];
                echo json_encode($msg);
            } else {

                $insertdata = [
                    'nama_survey'  => $this->request->getVar('nama_survey'),
                    'ket_stb'  => $this->request->getVar('ket_stb'),
                    'ket_kb'  => $this->request->getVar('ket_kb'),
                    'ket_b'  => $this->request->getVar('ket_b'),
                    'ket_sb'  => $this->request->getVar('ket_sb'),
                    'r1_stb'  => $this->request->getVar('r1_stb'),
                    'r2_stb'  => $this->request->getVar('r2_stb'),
                    'r1_kb'  => $this->request->getVar('r1_kb'),
                    'r2_kb'  => $this->request->getVar('r2_kb'),
                    'r1_b'  => $this->request->getVar('r1_b'),
                    'r2_b'  => $this->request->getVar('r2_b'),
                    'r1_sb'  => $this->request->getVar('r1_sb'),
                    'r2_sb'  => $this->request->getVar('r2_sb'),
                    'status'       => '0',
                    'id'           => session()->get('id')

                ];
                $this->surveytopik->insert($insertdata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan!'
                ];
                echo json_encode($msg);
            }
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('survey_id');

            $this->surveytopik->delete($id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $survey_id = $this->request->getVar('survey_id');
            $list =  $this->surveytopik->find($survey_id);

            $data = [
                'title'         => 'Edit Topik',
                'survey_id'     => $list['survey_id'],
                'nama_survey'   => $list['nama_survey'],

                'ket_stb'   => $list['ket_stb'],
                'ket_kb'   => $list['ket_kb'],
                'ket_b'   => $list['ket_b'],
                'ket_sb'   => $list['ket_sb'],

                'r1_stb'   => $list['r1_stb'],
                'r2_stb'   => $list['r2_stb'],
                'r1_kb'   => $list['r1_kb'],
                'r2_kb'   => $list['r2_kb'],
                'r1_b'   => $list['r1_b'],
                'r2_b'   => $list['r2_b'],
                'r2_kb'   => $list['r2_kb'],
                'r1_sb'   => $list['r1_sb'],
                'r2_sb'   => $list['r2_sb'],


            ];
            $msg = [
                'sukses' => view('admin/interaksi/surveytopik/edit', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function updatetopik()
    {
        if ($this->request->isAJAX()) {
            $survey_id = $this->request->getVar('survey_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama_survey' => [
                    'label' => 'Topik Survei',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ket_stb' => [
                    'label' => 'Keterangan stb',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ket_kb' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ket_b' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ket_sb' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_survey'    => $validation->getError('nama_survey'),
                        'ket_stb'        => $validation->getError('ket_stb'),
                        'ket_kb'         => $validation->getError('ket_kb'),
                        'ket_b'          => $validation->getError('ket_b'),
                        'ket_sb'         => $validation->getError('ket_sb'),
                    ]
                ];
            } else {

                $updatedata = [
                    'nama_survey'     => $this->request->getVar('nama_survey'),
                    'ket_stb'  => $this->request->getVar('ket_stb'),
                    'ket_kb'  => $this->request->getVar('ket_kb'),
                    'ket_b'  => $this->request->getVar('ket_b'),
                    'ket_sb'  => $this->request->getVar('ket_sb'),

                    'r1_stb'  => $this->request->getVar('r1_stb'),
                    'r2_stb'  => $this->request->getVar('r2_stb'),
                    'r1_kb'  => $this->request->getVar('r1_kb'),
                    'r2_kb'  => $this->request->getVar('r2_kb'),
                    'r1_b'  => $this->request->getVar('r1_b'),
                    'r2_b'  => $this->request->getVar('r2_b'),
                    'r1_sb'  => $this->request->getVar('r1_sb'),
                    'r2_sb'  => $this->request->getVar('r2_sb'),


                ];
                $this->surveytopik->update($survey_id, $updatedata);
                $msg = [
                    'sukses' => 'Data berhasil diubah!'
                ];
            }
            echo json_encode($msg);
        }
    }


    public function toggle()
    {
        if ($this->request->isAJAX()) {
            $survey_id = $this->request->getVar('survey_id');
            $cari =  $this->surveytopik->find($survey_id);

            if ($cari['status'] == '1') {
                $list =  $this->surveytopik->getaktif($survey_id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'status'        => $toggle,
                ];

                $this->surveytopik->update($survey_id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil nonaktifkan survei!'
                ];
            } else {
                $list =  $this->surveytopik->getnonaktif($survey_id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'status'        => $toggle,
                ];
                $this->surveytopik->resetdata();
                $this->surveytopik->update($survey_id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil mengaktifkan survei!'
                ];
            }

            echo json_encode($msg);
        }
    }

    // start RESPONDEn
    public function pesan($survey_id = null)
    {

        if ($survey_id == '') {

            return redirect()->to(base_url('surveytopik/all'));
        }
        $list =  $this->pertanyaan->listpertanyaan($survey_id);
        $data = [
            'title'     => 'Masukan Saran',
            'subtitle'  => 'Detail',
            'survey_id' => $survey_id,
            'list' => $list,

        ];
        return view('admin/interaksi/surveytopik/surveypesan/index', $data);
    }

    // get data pesan-------
    public function getpesan()
    {
        if ($this->request->isAJAX()) {
            $survey_id  = $this->request->getVar('survey_id');
            $list       =  $this->responden->listresponden($survey_id);

            if ($survey_id == '') {

                return redirect()->to(base_url('survey/all'));
            }

            $data = [
                'title'      => 'Pesan',
                'list'       => $list,
            ];
            $msg = [
                'data' => view('admin/interaksi/surveytopik/surveypesan/list', $data)
            ];

            echo json_encode($msg);
        } else {
            return redirect()->to(base_url('admin'));
        }
    }


    public function hapusrespon()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('responden_id');

            $this->responden->delete($id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }


    public function formpesan()
    {
        if ($this->request->isAJAX()) {

            $survey_id = $this->request->getVar('survey_id');
            $list =  $this->surveytopik->find($survey_id);

            $data = [
                'title'         => 'Masukan Saran',
                'survey_id'     => $list['survey_id'],
                'nama_survey'   => $list['nama_survey'],
                'pesan'          => $list['pesan'],
                'nohp'          => $list['nohp'],
                'nama'          => $list['nama'],

            ];
            $msg = [
                'sukses' => view('admin/interaksi/surveytopik/surveypesan/index', $data)
            ];
            echo json_encode($msg);
        }
    }


    // Detail pertayaan
    public function pertanyaan($survey_id = null)
    {

        if ($survey_id == '') {

            return redirect()->to(base_url('surveytopik/all'));
        }
        $list =  $this->pertanyaan->listpertanyaan($survey_id);
        $data = [
            'title'     => 'Pertanyaan',
            'subtitle'  => 'Quisioner',
            'survey_id' => $survey_id,
            'list' => $list,

        ];
        return view('admin/interaksi/surveytopik/surveypertanyaan/index', $data);
    }

    // get data
    public function getpertanyaan()
    {
        if ($this->request->isAJAX()) {
            $survey_id  = $this->request->getVar('survey_id');
            $list       =  $this->pertanyaan->listpertanyaan($survey_id);

            if ($survey_id == '') {

                return redirect()->to(base_url('survey/all'));
            }

            $data = [
                'title'      => 'Managemen Pertanyaan',
                'list'       => $list,
            ];
            $msg = [
                'data' => view('admin/interaksi/surveytopik/surveypertanyaan/list', $data)
            ];

            echo json_encode($msg);
        } else {
            return redirect()->to(base_url('admin'));
        }
    }

    public function formtambahpertanyaan()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Pertanyaan',
                'survey_id' => $this->request->getVar('survey_id'),
            ];
            $msg = [
                'data' => view('admin/interaksi/surveytopik/surveypertanyaan/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanPertanyaan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'pertanyaan'  => [
                    'label'   => 'Pertanyaan',
                    'rules'   => 'required|is_unique[survey_pertanyaan.pertanyaan]',
                    'errors'  => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'pertanyaan'  => $validation->getError('pertanyaan'),
                    ]
                ];
                echo json_encode($msg);
            } else {

                $insertdata = [
                    'survey_id'    => $this->request->getVar('survey_id'),
                    'pertanyaan'   => $this->request->getVar('pertanyaan'),
                    'status'       => '1',

                ];

                $this->pertanyaan->insert($insertdata);

                $msg = [
                    'sukses' => 'Data berhasil disimpan!'
                ];
                echo json_encode($msg);
            }
        }
    }

    public function formeditpertanyaan()
    {
        if ($this->request->isAJAX()) {

            $pertanyaan_id = $this->request->getVar('pertanyaan_id');

            $list =  $this->pertanyaan->find($pertanyaan_id);

            $data = [
                'title'         => 'Edit Pertanyaan',
                'pertanyaan_id'   => $pertanyaan_id,
                'pertanyaan' => $list['pertanyaan'],
            ];
            $msg = [
                'sukses' => view('admin/interaksi/surveytopik/surveypertanyaan/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatepertanyaan()
    {
        if ($this->request->isAJAX()) {
            $pertanyaan_id = $this->request->getVar('pertanyaan_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'pertanyaan' => [
                    'label' => 'Pertanyaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'pertanyaan' => $validation->getError('pertanyaan'),
                    ]
                ];
            } else {
                $updatedata = [
                    'pertanyaan'  => $this->request->getVar('pertanyaan'),

                ];
                $this->pertanyaan->update($pertanyaan_id, $updatedata);
                $msg = [
                    'sukses' => 'Data berhasil diubah!'
                ];
            }
            echo json_encode($msg);
        }
    }

    //Hapus

    public function hapuspertanyaan()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('pertanyaan_id');
            //check
            $this->pertanyaan->delete($id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusperall()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('pertanyaan_id');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {

                $this->pertanyaan->delete($id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata Data berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    // end tanya & Start Jawab=====================================================


    public function jawaban($pertanyaan_id = null)
    {

        if ($pertanyaan_id == '') {

            return redirect()->to(base_url('survey/all'));
        }
        $list =  $this->jawaban->listjawaban($pertanyaan_id);
        $data = [
            'title'     => 'Survei',
            'subtitle'  => 'Jawaban',
            'pertanyaan_id' => $pertanyaan_id,
            'list' => $list,

        ];
        return view('admin/interaksi/surveytopik/surveyjawaban/index', $data);
    }

    // get datajawaban
    public function getjawaban()
    {
        if ($this->request->isAJAX()) {
            $pertanyaan_id = $this->request->getVar('pertanyaan_id');
            $list =  $this->jawaban->listjawaban($pertanyaan_id);

            if ($pertanyaan_id == '') {

                return redirect()->to(base_url('survey/all'));
            }

            $data = [
                'title'      => 'Management Jawaban',
                'list'       => $list,
            ];
            $msg = [
                'data' => view('admin/interaksi/surveytopik/surveyjawaban/list', $data)
            ];

            echo json_encode($msg);
        } else {
            return redirect()->to(base_url('admin'));
        }
    }


    public function formtambahjawaban()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Jawaban',
                'pertanyaan_id' => $this->request->getVar('pertanyaan_id'),
            ];
            $msg = [
                'data' => view('admin/interaksi/surveytopik/surveyjawaban/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function simpanjawaban()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('pertanyaan_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'jawaban' => [
                    'label' => 'Jawaban',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'jawaban'  => $validation->getError('jawaban'),

                    ]
                ];
            } else {

                $insertdata = [
                    'pertanyaan_id'    => $this->request->getVar('pertanyaan_id'),
                    'jawaban'    => $this->request->getVar('jawaban'),
                    'nilai'    => $this->request->getVar('nilai'),
                ];

                $this->jawaban->insert($insertdata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan!',
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditjawaban()
    {
        if ($this->request->isAJAX()) {

            $jawaban_id = $this->request->getVar('jawaban_id');

            $list =  $this->jawaban->find($jawaban_id);

            $data = [
                'title'         => 'Edit Data',
                'jawaban_id'    => $jawaban_id,
                'pertanyaan_id'   => $list['pertanyaan_id'],
                'jawaban' => $list['jawaban'],
                'nilai' => $list['nilai'],
            ];
            $msg = [
                'sukses' => view('admin/interaksi/surveytopik/surveyjawaban/edit', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function updatejawaban()
    {
        if ($this->request->isAJAX()) {
            $jawaban_id = $this->request->getVar('jawaban_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'jawaban' => [
                    'label' => 'Jawaban',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong.',
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'jawaban' => $validation->getError('jawaban'),
                    ]
                ];
            } else {

                //check
                $updatedata = [
                    'jawaban'  => $this->request->getVar('jawaban'),
                    'nilai'  => $this->request->getVar('nilai'),

                ];

                $this->jawaban->update($jawaban_id, $updatedata);
                $msg = [
                    'sukses' => 'Data berhasil diubah!'
                ];
            }
            echo json_encode($msg);
        }
    }


    public function hapusjawaban()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('jawaban_id');

            $this->jawaban->delete($id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusjwball()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('jawaban_id');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check

                $this->jawaban->delete($id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata Data berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    // simpan survei
    public function simsur()
    {
        if ($this->request->isAJAX()) {
            $jawaban_id = $this->request->getVar('jawaban_id');
            $listpol   =  $this->jawaban->listjawabanx();
            $jmldata = count($jawaban_id);
            for ($i = 0; $i < $jmldata; $i++) {

                $data = [

                    'nilai'        => $listpol['nilai'] + 1
                ];
                $this->jawaban->update($jawaban_id, $data);
            }
            $msg = [
                'sukses' => "$jmldata video berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }
    public function isisurvei()
    {
        if ($this->request->isAJAX()) {

            if (get_cookie("survei") != 'cossi') {
                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'jawaban_id' => [
                        'label' => 'Pilihan',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ]
                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            'jawaban_id' => $validation->getError('jawaban_id'),
                        ]
                    ];
                } else {

                    $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                    $secretkey = $konfigurasi['g_secretkey'];
                    $g_sitekey = $konfigurasi['g_sitekey'];

                    // gcaptcha
                    $recaptchaResponse = trim($this->request->getVar('g-recaptcha-response'));
                    $secret = $secretkey;

                    $jawaban_id = $this->request->getVar('jawaban_id');
                    $survey_id = $this->request->getVar('survey_id');
                    $nilai = $this->request->getVar('nilai');
                    $jmldata = count($jawaban_id);
                    $listtopik =  $this->surveytopik->find($survey_id);

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

                            // eksekusi
                            for ($i = 0; $i < $jmldata; $i++) {
                                $data = [
                                    'skor'        => $listtopik['skor'] + $nilai
                                ];
                                $this->surveytopik->update($survey_id, $data);
                            }

                            $updatedata = [
                                'hits'        => $listtopik['hits'] + 1,
                            ];

                            $this->surveytopik->update($survey_id, $updatedata);
                            $insertdata = [
                                'survey_id'   => $survey_id,
                                'saran'       => $this->request->getVar('saran'),
                                'nohp'       => $this->request->getVar('nohp'),
                                'nama'       => $this->request->getVar('nama'),
                                'tanggal'     => date('Y-m-d'),
                            ];
                            $this->responden->insert($insertdata);
                            set_cookie("survei", "cossi", 7000);
                            $msg = [
                                'sukses' => 'Terima kasih atas partisipasi anda mengikuti survei kami.!'
                            ];
                        } else {
                            $msg = [
                                'gagal' => 'Gagal kirim survei Silahkan periksa Kembali!'
                            ];
                        }

                        // no google
                    } else {
                        for ($i = 0; $i < $jmldata; $i++) {
                            $data = [
                                'skor'        => $listtopik['skor'] + $nilai
                            ];
                            $this->surveytopik->update($survey_id, $data);
                        }

                        $updatedata = [
                            'hits'        => $listtopik['hits'] + 1,
                        ];

                        $this->surveytopik->update($survey_id, $updatedata);
                        $insertdata = [
                            'survey_id'   => $survey_id,
                            'saran'       => $this->request->getVar('saran'),
                            'nohp'       => $this->request->getVar('nohp'),
                            'nama'       => $this->request->getVar('nama'),
                            'tanggal'     => date('Y-m-d'),
                        ];
                        $this->responden->insert($insertdata);
                        set_cookie("survei", "cossi", 7000);
                        $msg = [
                            'sukses' => 'Terima kasih atas partisipasi anda mengikuti survei kami.!'
                        ];
                    }

                    // end isi
                }

                // jika sudah isi
            } else {
                $msg = [
                    'gagal' => 'Anda telah berpartisipasi..!'
                ];
            }
            echo json_encode($msg);
        }
    }
}
