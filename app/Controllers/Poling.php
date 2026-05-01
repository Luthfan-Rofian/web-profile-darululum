<?php

namespace App\Controllers;

class Poling extends BaseController
{

    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $data = [
            'title'           => 'Interaksi',
            'subtitle'        => 'Jajak Pendapat',

        ];

        return view('admin/interaksi/poling/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {

            $id_grup = session()->get('id_grup');
            $url = 'poling';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);
            $jumpol = $this->poling->polling_sum();

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Jajak Pendapat',
                        'list'      => $this->poling->list(),
                        'jumpol'    => $jumpol['jml_vote'],
                        'poljawab'  => $this->poling->poljawab(),
                        'akses'     => $akses
                    ];
                    $msg = [
                        'data' => view('admin/interaksi/poling/list', $data)
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
                'title' => 'Tambah Jawaban'
            ];
            $msg = [
                'data' => view('admin/interaksi/poling/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function simpanpoling()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'pilihan' => [
                    'label' => 'Jawaban',
                    'rules' => 'required|is_unique[poling.pilihan]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'pilihan' => $validation->getError('pilihan'),

                    ]
                ];
            } else {
                $userid = session()->get('id');
                $simpandata = [
                    'pilihan' => $this->request->getVar('pilihan'),
                    'type' => 'Jawaban',
                    'id' => $userid
                ];

                $this->poling->insert($simpandata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $poling_id = $this->request->getVar('poling_id');
            $list =  $this->poling->find($poling_id);
            $data = [
                'title'       => 'Edit Data',
                'poling_id'   => $list['poling_id'],
                'pilihan'     => $list['pilihan'],
                'jenis'       => $list['type'],
                'rating'       => $list['rating']
            ];
            $msg = [
                'sukses' => view('admin/interaksi/poling/edit', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function updatepoling()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'pilihan' => [
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
                        'pilihan' => $validation->getError('pilihan'),
                    ]
                ];
            } else {
                $updatedata = [
                    'pilihan' => $this->request->getVar('pilihan'),
                    'rating' => $this->request->getVar('rating'),
                ];

                $poling_id = $this->request->getVar('poling_id');
                $this->poling->update($poling_id, $updatedata);
                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }


    public function ubahpoling()
    {
        if ($this->request->isAJAX()) {

            $poling_id = $this->request->getVar('poling_id');
            $listpol =  $this->poling->find($poling_id);

            if (get_cookie("poling") != 'isipoling') {
                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'poling_id' => [
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
                            'poling_id' => $validation->getError('poling_id'),
                        ]
                    ];
                } else {

                    $data = [
                        'rating'        => $listpol['rating']  + 1
                    ];
                    $this->poling->update($poling_id, $data);

                    // set_cookie("poling", "isipoling", 86400); 1 hari
                    set_cookie("poling", "isipoling", 43200);

                    $msg = [
                        'sukses' => 'Terima kasih atas partisipasi anda mengikuti polling kami'
                    ];
                }
            } else {
                $msg = [
                    'gagal' => 'Anda sudah berpartisipasi..!'
                ];
            }
            echo json_encode($msg);
        }
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $poling_id = $this->request->getVar('poling_id');

            $this->poling->delete($poling_id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }



    public function lihatpoling()
    {
        if ($this->request->isAJAX()) {

            $poljawab = $this->poling->poljawab();
            $jumpol = $this->poling->polling_sum();
            // $template = $this->template->tempaktif();
            $data = [
                'title' => 'Hasil Jajak Pendapat',
                'poljawab' => $poljawab,
                'jumpol' => $jumpol['jml_vote'],

            ];
            $msg = [

                'data' => view('admin/modal/lihatpoling', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function toggle()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $cari =  $this->poling->find($id);

            if ($cari['status'] == 'Y') {
                $list =  $this->poling->getaktif($id);
                $toggle = $list ? 'N' : 'Y';
                $updatedata = [
                    'status'        => $toggle,
                ];
                $this->poling->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil nonaktifkan poling!'
                ];
            } else {
                $list =  $this->poling->getnonaktif($id);
                $toggle = $list ? 'Y' : 'N';
                $updatedata = [
                    'status'        => $toggle,
                ];
                $this->poling->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil mengaktifkan poling!'
                ];
            }

            echo json_encode($msg);
        }
    }
}
