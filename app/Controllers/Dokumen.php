<?php

namespace App\Controllers;

class Dokumen extends BaseController
{

    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'        => 'Dokumen',
            'subtitle'     => 'Data',
        ];

        return view('admin/cmscust/dokumen/index', $data);
    }


    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $urlget = 'dokumen';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $urlget);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;

            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Berita',
                        'list'      => 'cmsdatagoe',
                        'urlget'    => $urlget,
                    ];

                    $msg = [
                        'data' => view('admin/cmscust/dokumen/list', $data)
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

    // Start Serverside

    public function listdata2()
    {

        $request = \Config\Services::request();

        $list_data = $this->dokumen;

        // $level = session()->get('level');
        $id = session()->get('id');

        $id_grup    = session()->get('id_grup');
        $urlget     = 'dokumen';
        $listgrupf  =  $this->grupakses->listgrupakses($id_grup, $urlget);

        foreach ($listgrupf as $data) :
            $akses = $data['akses'];
        endforeach;

        if ($akses == '1') {

            $where = [];
        } elseif ($akses == '2') {
            $where = [
                'custome__dokumenupl.id =' => $id

            ];
        }

        $column_order = array(null, 'custome__dokumenupl.nama_dok', 'custome__dokumenupl.tgl_upload', null, null);
        $column_search = array('custome__dokumenupl.nama_dok', 'custome__dokumenupl.tgl_upload');
        $order = array('custome__dokumenupl.id_dokumenupl' => 'DESC');
        $lists = $list_data->get_datatables('custome__dokumenupl', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $idopd = $list->opd_id;
            $cekopd = $this->db->table('custome__opd')->where('opd_id', $idopd)->get()->getRowArray();
            if (!$cekopd) {
                $opd = '-';
            } else {
                if ($idopd == '0') {
                    $opd = '-';
                } else {
                    $opd = $cekopd['nama_opd'];
                }
            }
            $namadok = '<i class="icon fas fa-file-alt text-success text-success ml-0 pointer" onclick="uploadfile(' . $list->id_dokumenupl . ')" title="Ganti file"></i> <label> ' . $list->nama_dok . ' </label>';
            $tview = '<a <button type="button" class="btn btn-success btn-sm p-1" href="' . base_url() . '/public/unduh/dokumen/' . $list->file_dok . '" target="_blank" ><i class="fas fa-search text-light"></i></button></a>';
            $tedit = '<button type="button" class="btn btn-info btn-sm p-1" onclick="edit(' . $list->id_dokumenupl . ')"><i class="fa fa-edit text-light"></i></button>';
            $thapus = '<button type="button" class="btn btn-danger btn-sm p-1" onclick="hapus(' . $list->id_dokumenupl . ')"><i class="far fa-trash-alt text-light"></i></button>';

            $row   = [];
            $row[] = "<input type=\"checkbox\" name=\"id_dokumenupl[]\" class=\"centang_id\" value=\"$list->id_dokumenupl\">";
            // $row[] = $no;
            $row[] = $namadok;
            $row[] = $list->nama_katdok;
            $row[] = date_indo($list->tgl_upload);
            $row[] = $list->fullname;
            $row[] = $opd;

            $row[] = $tview . " " . $tedit . " " . $thapus;
            $data[] = $row;
        }

        if ($akses == '1') {
            $total_count = $this->db->query("SELECT * FROM `custome__dokumenupl`")->getResult();
        } elseif ($akses == '2') {
            $total_count = $this->db->query(" SELECT * FROM `custome__dokumenupl` WHERE id='" . $id . "' ")->getResult();
        }

        $output = array(
            "draw"              => $request->getPost("draw"),
            "recordsTotal"      => count($total_count),
            "recordsFiltered"   => count($total_count),

            "data" => $data,
        );

        return json_encode($output);
    }


    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Dokumen',
                'kat' => $this->dokumenkat->list()
            ];
            $msg = [
                'data' => view('admin/cmscust/dokumen/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanDokumen()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama_dok' => [
                    'label' => 'Nama Dokumen',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        // 'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'id_katdok' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Silahkan pilih {field}',
                        // 'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'file_dok' => [
                    'label' => 'file',
                    'rules' => [
                        'uploaded[file_dok]',
                        'mime_in[file_dok,image/jpg,image/jpeg,image/gif,image/png,application/pdf,application/doc,application/docx,application/xls,application/xlsx,application/ppt,application/pptx,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                        'max_size[file_dok,9096]',
                    ],
                    'errors' => [
                        'uploaded' => 'Silahkan Masukkan file',
                        'max_size' => 'Ukuran {field} Maksimal 9096 KB..!!',
                        'mime_in' => 'Format {field} tidak valid..!!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_dok'     => $validation->getError('nama_dok'),
                        'id_katdok'     => $validation->getError('id_katdok'),
                        'file_dok'     => $validation->getError('file_dok'),
                    ]
                ];
                echo json_encode($msg);
            } else {

                $userid = session()->get('id');
                $dtfile_dok = $this->request->getFile('file_dok');
                $nama_file = $dtfile_dok->getRandomName();

                $insertdata = [

                    'nama_dok'      => $this->request->getVar('nama_dok'),
                    'id_katdok'     => $this->request->getVar('id_katdok'),
                    'ket'           => $this->request->getVar('ket'),
                    'file_dok'      => $nama_file,
                    'tgl_upload'    => date('Y-m-d'),
                    'id'            => $userid,

                ];

                $this->dokumen->insert($insertdata);
                $dtfile_dok->move('public/unduh/dokumen/', $nama_file); //folder gambar

                $msg = [
                    'sukses' => 'Dokumen berhasil disimpan!'
                ];

                echo json_encode($msg);
            }
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id_dokumenupl');
            //check
            $cekdata = $this->dokumen->find($id);
            $filelama = $cekdata['file_dok'];
            if ($filelama != '' && file_exists('public/unduh/dokumen/' . $filelama)) {
                unlink('public/unduh/bankdata/' . $filelama);
            }

            $this->dokumen->delete($id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_dokumenupl');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->dokumen->find($id[$i]);
                $filelama = $cekdata['file_dok'];
                if ($filelama != '' && file_exists('public/unduh/dokumen/' . $filelama)) {
                    unlink('public/unduh/bankdata/' . $filelama);
                }
                $this->dokumen->delete($id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata Data berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $id_dokumenupl = $this->request->getVar('id_dokumenupl');
            $list =  $this->dokumen->find($id_dokumenupl);

            $data = [
                'title'          => 'Edit Data',
                'id_dokumenupl'  => $list['id_dokumenupl'],
                'nama_dok'       => $list['nama_dok'],
                'id_katdok'      => $list['id_katdok'],
                'ket'            => $list['ket'],
                'kat'            => $this->dokumenkat->list()

            ];
            $msg = [
                'sukses' => view('admin/cmscust/dokumen/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatedokumen()
    {
        if ($this->request->isAJAX()) {
            $id_dokumenupl = $this->request->getVar('id_dokumenupl');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama_dok' => [
                    'label' => 'Nama Dokumen',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_dok'           => $validation->getError('nama_dok'),
                    ]
                ];
            } else {

                $updatedata = [

                    'nama_dok'      => $this->request->getVar('nama_dok'),
                    'id_katdok'     => $this->request->getVar('id_katdok'),
                    'ket'           => $this->request->getVar('ket'),

                ];

                $this->dokumen->update($id_dokumenupl, $updatedata);

                $msg = [
                    'sukses' => 'Data berhasil diubah!'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formuploadfile()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_dokumenupl');
            $list =  $this->dokumen->find($id);
            $data = [
                'title'       => 'Upload File',
                'id'          => $list['id_dokumenupl'],
                'file_dok'   => $list['file_dok']

            ];
            $msg = [
                'sukses' => view('admin/cmscust/dokumen/gantifile', $data)
            ];
            echo json_encode($msg);
        }
    }

    //simpan fileunduh
    public function douploaddokumen()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id_dokumenupl');
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'file_dok' => [
                    'label' => 'File unduhan',
                    'rules' => [
                        'uploaded[file_dok]',
                        'mime_in[file_dok,image/jpg,image/jpeg,image/gif,image/png,application/pdf,application/doc,application/docx,application/xls,application/xlsx,application/ppt,application/pptx,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                        'max_size[file_dok,9096]',
                    ],
                    'errors' => [
                        'uploaded' => 'Silahkan Masukkan file',
                        'max_size' => 'Ukuran {field} Maksimal 9096 KB..!!',
                        'mime_in' => 'Format {field} tidak valid..!! '
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'file_dok' => $validation->getError('file_dok')
                    ]
                ];
            } else {

                //check
                $cekdata = $this->dokumen->find($id);
                $filelama = $cekdata['file_dok'];

                if ($filelama != '' && file_exists('public/unduh/dokumen/' . $filelama)) {
                    unlink('public/unduh/bankdata/' . $filelama);
                }

                $fileunduhan = $this->request->getFile('file_dok');
                $nama_file = $fileunduhan->getRandomName();
                $updatedata = [
                    'file_dok' => $nama_file
                ];

                $this->dokumen->update($id, $updatedata);
                $fileunduhan->move('public/unduh/dokumen/', $nama_file); //folder file

                $msg = [
                    'sukses' => 'File berhasil diupload!',
                ];
            }
            echo json_encode($msg);
        }
    }

    //Start kategori (backend)--------------------

    public function kategori()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'       => 'Kelola Data',
            'subtitle'    => 'Kategori',
        ];
        return view('admin/cmscust/dokumen/kategori/index', $data);
    }

    public function getkategori()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'dokumen/kategori';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1') {
                    $data = [
                        'title'     => 'Kategori Dokumen',
                        'list'      => $this->dokumenkat->list(),
                        'akses'     => '1'
                    ];
                    $msg = [
                        'data' => view('admin/cmscust/dokumen/kategori/list', $data)
                    ];
                } elseif ($akses == '2') {

                    $data = [
                        'title'     => 'Kategori Dokumen',
                        'list'      => $this->dokumenkat->list(),
                        'akses'     => '2'
                    ];
                    $msg = [
                        'data' => view('admin/cmscust/dokumen/kategori/list', $data)
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

    public function formkategori()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Kategori'
            ];
            $msg = [
                'data' => view('admin/cmscust/dokumen/kategori/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpankategori()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_katdok' => [
                    'label' => 'Kategori Dokumen',
                    'rules' => 'required|is_unique[custome__katdok.nama_katdok]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_katdok' => $validation->getError('nama_katdok'),
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_katdok' => $this->request->getVar('nama_katdok'),
                    // 'slug_kategori' => $this->request->getVar('slug_kategori'),
                ];

                $this->dokumenkat->insert($simpandata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditkategori()
    {
        if ($this->request->isAJAX()) {
            $id_katdok = $this->request->getVar('id_katdok');
            $list =  $this->dokumenkat->find($id_katdok);
            $data = [
                'title'         => 'Edit Kategori',
                'id_katdok'     => $list['id_katdok'],
                'nama_katdok'   => $list['nama_katdok'],
            ];
            $msg = [
                'sukses' => view('admin/cmscust/dokumen/kategori/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatekategori()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_katdok' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_katdok' => $validation->getError('nama_katdok'),
                    ]
                ];
            } else {
                $updatedata = [
                    'nama_katdok' => $this->request->getVar('nama_katdok'),
                    // 'slug_kategori' => $this->request->getVar('slug_kategori'),
                ];

                $id_katdok = $this->request->getVar('id_katdok');
                $this->dokumenkat->update($id_katdok, $updatedata);

                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapuskategori()
    {
        if ($this->request->isAJAX()) {
            $id_katdok = $this->request->getVar('id_katdok');
            $this->dokumenkat->delete($id_katdok);
            $msg = [
                'sukses' => 'Kategori Dokumen Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }
}
