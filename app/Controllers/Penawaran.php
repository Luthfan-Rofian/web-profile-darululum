<?php

namespace App\Controllers;

class Penawaran extends BaseController
{
    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $id_grup = session()->get('id_grup');
        $url = 'penawaran';
        $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

        foreach ($listgrupf as $data) :
            $akses = $data['akses'];
        endforeach;
        // jika temukan maka eksekusi
        if ($listgrupf) {
            # cek akses
            if ($akses == '1' || $akses == '2') {

                $list =  $this->modalpopup->orderBy('modalpopup_id ')->first();
                $data = [
                    'title'            => 'Setting',
                    'subtitle'         => 'Modal Popup',
                    'konfigurasi'      => $this->konfigurasi->list(),
                    'modalpopup_id'    => $list['modalpopup_id'],
                    'judultawaran'     => $list['judultawaran'],
                    'isitawaran'       => $list['isitawaran'],
                    'gbrtawaran'       => $list['gbrtawaran'],
                    'linktawaran'      => $list['linktawaran'],
                    'namatombol'       => $list['namatombol'],
                    'sts_tombol'       => $list['sts_tombol'],
                    'akses'            => $akses
                ];
                return view('admin/modal/penawaran/penawaran', $data);
            } else {

                return redirect()->to(base_url('dashboard'));
            }
        } else {

            return redirect()->to(base_url('dashboard'));
        }
    }

    public function submit()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'judultawaran' => [
                    'label' => 'Judul Modal Popup',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'isitawaran' => [
                    'label' => 'Isi Modal Popup',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'linktawaran' => [
                    'label' => 'Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'namatombol' => [
                    'label' => 'Tombol Modal',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'judultawaran'    => $validation->getError('judultawaran'),
                        'isitawaran'      => $validation->getError('isitawaran'),
                        'linktawaran'     => $validation->getError('linktawaran'),
                        'namatombol'      => $validation->getError('namatombol'),
                    ]
                ];
            } else {
                $simpandata = [
                    'judultawaran'        => $this->request->getVar('judultawaran'),
                    'isitawaran'          => $this->request->getVar('isitawaran'),
                    'linktawaran'         => $this->request->getVar('linktawaran'),
                    'namatombol'          => $this->request->getVar('namatombol'),
                    'sts_tombol'          => $this->request->getVar('sts_tombol'),

                ];
                $modalpopup_id  = $this->request->getVar('modalpopup_id ');
                $this->modalpopup->update($modalpopup_id, $simpandata);
                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formuploadtawaran()
    {
        if ($this->request->isAJAX()) {
            $modalpopup_id = $this->request->getVar('modalpopup_id');
            $list = $this->modalpopup->find($modalpopup_id);
            $data = [
                'title' => 'Upload Gambar',
                'list'  => $list,
                'modalpopup_id' => $list['modalpopup_id']
            ];
            $msg = [
                'sukses' => view('admin/modal/penawaran/uploadlogo', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function douploadlogo()
    {
        if ($this->request->isAJAX()) {

            $modalpopup_id = $this->request->getVar('modalpopup_id');
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'gbrtawaran' => [
                    'label' => 'Upload Gambar',
                    'rules' => 'uploaded[gbrtawaran]|mime_in[gbrtawaran,image/png,image/jpg,image/jpeg]|is_image[gbrtawaran]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar',
                        'mime_in' => 'Harus gambar!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'gbrtawaran' => $validation->getError('gbrtawaran')
                    ]
                ];
            } else {
                //check
                $cekdata = $this->modalpopup->find($modalpopup_id);
                $fotolama = $cekdata['gbrtawaran'];
                if ($fotolama != 'default.png' && file_exists('public/img/konfigurasi/pimpinan/' . $fotolama)) {
                    unlink('public/img/konfigurasi/pimpinan/' . $fotolama);
                }

                $filegambar = $this->request->getFile('gbrtawaran');
                $updatedata = [
                    'gbrtawaran' => $filegambar->getName(),
                ];

                $this->modalpopup->update($modalpopup_id, $updatedata);
                $filegambar->move('public/img/konfigurasi/pimpinan');
                $msg = [
                    'sukses' => 'Gambar berhasil diupload!',
                ];
            }
            echo json_encode($msg);
        }
    }

    public function lihathasiladmin()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title'       => 'Tampilan POPUP',
                'konfigurasi' => $this->modalpopup->orderBy('modalpopup_id')->first(),
            ];
            $msg = [
                'data' => view('admin/modal/penawaran/viewpenawaran', $data)
            ];
            echo json_encode($msg);
        }
    }
}
