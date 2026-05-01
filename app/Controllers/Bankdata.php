<?php

namespace App\Controllers;

class Bankdata extends BaseController
{
    public function index()
    {

        $konfigurasi        = $this->konfigurasi->vkonfig();
        $template           = $this->template->tempaktif();
        $data = [
            'title'         => 'Bank Data',
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),
            'list'          => $this->bankdata->listbankdata(),
            'beritapopuler' => $this->berita->populer()->paginate(8),
            'kategori'      => $this->kategori->list(),
            'banner'        => $this->banner->list(),
            'infografis'    => $this->banner->listinfo(),
            'infografis1'   => $this->banner->listinfo1(),
            'agenda'        => $this->agenda->listagendapage()->paginate(4),
            'section'       => $this->section->list(),
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'infografis10'    => $this->banner->listinfopage()->paginate(10),
            'kategori'      => $this->kategori->list(),
            'folder'        => $template['folder']
        ];
        return view('' . $template['folder'] . '/' . 'content/semua_bankdata', $data);
    }

    //list semua bankdata
    public function all()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'        => 'Informasi',
            'subtitle'    => 'Bank Data',

        ];
        return view('admin/informasi/bankdata/index', $data);
    }


    public function getdata($id = null)
    {
        if ($this->request->isAJAX()) {
            $id          = session()->get('id');
            $id_grup = session()->get('id_grup');
            $url = 'bankdata/all';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1') {
                    $data = [
                        'title'     => 'Bank Data',
                        'list'      => $this->bankdata->listbankdata()
                    ];
                    $msg = [
                        'data' => view('admin/informasi/bankdata/list', $data)
                    ];
                } elseif ($akses == '2') {

                    $data = [
                        'title'     => 'Bank Data',
                        'list'      => $this->bankdata->listbankdataauthor($id)
                    ];
                    $msg = [
                        'data' => view('admin/informasi/bankdata/list', $data)
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
                'title' => 'Tambah Bank Data',
            ];
            $msg = [
                'data' => view('admin/informasi/bankdata/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanBankData()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $ukuran = 50000;
            $valid = $this->validate([
                'nama_bankdata' => [
                    'label' => 'Judul',
                    'rules' => 'required|is_unique[bankdata.nama_bankdata]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'fileupload' => [
                    'label' => 'file',
                    'rules' => [
                        'uploaded[fileupload]',
                        'mime_in[fileupload,image/jpg,image/jpeg,image/gif,image/png,application/pdf,application/doc,application/docx,application/xls,application/xlsx,application/ppt,application/pptx,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                        'max_size[fileupload,' . $ukuran . ']',
                    ],
                    'errors' => [
                        'uploaded' => 'Silahkan Masukkan file',
                        'max_size' => 'Ukuran {field} Maksimal ' . $ukuran . ' KB..!!',
                        'mime_in' => 'Format {field} tidak valid..!!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_bankdata'  => $validation->getError('nama_bankdata'),
                        'fileupload'     => $validation->getError('fileupload'),

                    ]
                ];
                echo json_encode($msg);
            } else {

                $userid = session()->get('id');
                $dtfileupload = $this->request->getFile('fileupload');
                $nama_file = $dtfileupload->getRandomName();
                $ext = $dtfileupload->getClientExtension();
                if ($ext == 'php' || $ext == 'js') {
                    $msg = [
                        'nofile' => 'File tidak diijinkan!'
                    ];
                } else {
                    $insertdata = [

                        'nama_bankdata' => $this->request->getVar('nama_bankdata'),
                        'slug_bank'     => mb_url_title($this->request->getVar('nama_bankdata'), '-', TRUE),
                        'fileupload'    => $nama_file,
                        'tgl_upload'    => date('Y-m-d'),
                        'id'            => $userid,
                        'hits'          => '0'

                    ];

                    $this->bankdata->insert($insertdata);
                    $dtfileupload->move('public/unduh/bankdata/', $nama_file); //folder gambar

                    $msg = [
                        'sukses' => 'Bank data berhasil disimpan!'
                    ];
                }
                echo json_encode($msg);
            }
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('bankdata_id');
            //check
            $cekdata = $this->bankdata->find($id);
            $filelama = $cekdata['fileupload'];
            if ($filelama != '' && file_exists('public/unduh/bankdata/' . $filelama)) {
                unlink('public/unduh/bankdata/' . $filelama);
            }
            $this->bankdata->delete($id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('bankdata_id');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->bankdata->find($id[$i]);
                $filelama = $cekdata['fileupload'];
                if ($filelama != '' && file_exists('public/unduh/bankdata/' . $filelama)) {
                    unlink('public/unduh/bankdata/' . $filelama);
                }
                $this->bankdata->delete($id[$i]);
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

            $bankdata_id = $this->request->getVar('bankdata_id');
            $list =  $this->bankdata->find($bankdata_id);
            // $size_mb = $list['fileupload']->getSize('mb'); // 
            $data = [
                'title'          => 'Edit Data',
                'bankdata_id'    => $list['bankdata_id'],
                'nama_bankdata'  => $list['nama_bankdata'],
                'ket'            => $list['ket'],

            ];
            $msg = [
                'sukses' => view('admin/informasi/bankdata/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatebankdata()
    {
        if ($this->request->isAJAX()) {
            $bankdata_id = $this->request->getVar('bankdata_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama_bankdata' => [
                    'label' => 'Nama File',
                    'rules' => 'required[bankdata.nama_bankdata]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_bankdata'           => $validation->getError('nama_bankdata'),
                    ]
                ];
            } else {

                $updatedata = [

                    'nama_bankdata' => $this->request->getVar('nama_bankdata'),
                    'slug_bank'     => mb_url_title($this->request->getVar('nama_bankdata'), '-', TRUE),

                ];

                $this->bankdata->update($bankdata_id, $updatedata);

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
            $id = $this->request->getVar('bankdata_id');
            $list =  $this->bankdata->find($id);
            $data = [
                'title'       => 'Upload File',
                'id'          => $list['bankdata_id'],
                'fileupload'   => $list['fileupload']

            ];
            $msg = [
                'sukses' => view('admin/informasi/bankdata/gantifile', $data)
            ];
            echo json_encode($msg);
        }
    }

    //simpan fileunduh
    public function douploadbankdata()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('bankdata_id');
            $validation = \Config\Services::validation();
            $ukuran = 50000;
            $valid = $this->validate([
                'fileupload' => [
                    'label' => 'File unduhan',
                    'rules' => [
                        'uploaded[fileupload]',
                        // 'mime_in[fileupload,image/jpg,image/jpeg,image/gif,image/png,application/pdf,application/doc,application/docx,application/xls,application/xlsx,application/ppt,application/pptx,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                        'max_size[fileupload,' . $ukuran . ']',
                    ],
                    'errors' => [
                        'uploaded' => 'Silahkan Masukkan file',
                        'max_size' => 'Ukuran {field} Maksimal ' . $ukuran . ' KB..!!',
                        // 'mime_in' => 'Format {field} tidak valid..!! '
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'fileupload' => $validation->getError('fileupload')
                    ]
                ];
            } else {

                $fileunduhan = $this->request->getFile('fileupload');
                $nama_file = $fileunduhan->getRandomName();

                $ext = $fileunduhan->getClientExtension();
                if ($ext == 'php' || $ext == 'js') {
                    $msg = [
                        'nofile' => 'File tidak diijinkan!'
                    ];
                } else {

                    //check
                    $cekdata = $this->bankdata->find($id);
                    $filelama = $cekdata['fileupload'];

                    if ($filelama != '' && file_exists('public/unduh/bankdata/' . $filelama)) {
                        unlink('public/unduh/bankdata/' . $filelama);
                    }

                    $updatedata = [
                        'fileupload' => $nama_file
                    ];

                    $this->bankdata->update($id, $updatedata);
                    $fileunduhan->move('public/unduh/bankdata/', $nama_file); //folder foto

                    $msg = [
                        'sukses' => 'File berhasil diupload!',
                    ];
                }
            }
            echo json_encode($msg);
        }
    }


    //frontend
    public function getbankdata()
    {
        if ($this->request->isAJAX()) {

            $bankdata_id = $this->request->getVar('bankdata_id');
            $list =  $this->bankdata->find($bankdata_id);
            $data = [
                'hits'        => $list['hits'] + 1
            ];
            $this->bankdata->update($list['bankdata_id'], $data);
            $msg = [
                // 'data' => view('content/semua_bankdata', $data)
            ];
            echo json_encode($msg);
        }
    }
}
