<?php

namespace App\Controllers;

class Sambutan extends BaseController
{

    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $id_grup = session()->get('id_grup');
        $url = 'sambutan';
        $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

        foreach ($listgrupf as $data) :
            $akses = $data['akses'];
        endforeach;
        // jika temukan maka eksekusi
        if ($listgrupf) {
            # cek akses
            if ($akses == '1' || $akses == '2') {

                $list =  $this->konfigurasi->orderBy('id_setaplikasi ')->first();
                $data = [
                    'title'              => 'Dashboard',
                    'subtitle'           => 'Kata Sambutan',
                    'konfigurasi'        => $this->konfigurasi->list(),
                    'id_setaplikasi'     => $list['id_setaplikasi'],
                    'sambutan'           => $list['sambutan'],
                    'gbr_sambutan'       => $list['gbr_sambutan'],
                    'nama_pimpinan'       => $list['nama_pimpinan'],
                    'jabatan_pimpinan'       => $list['jabatan_pimpinan'],
                    'sts_sambutan'       => $list['sts_sambutan'],
                    'akses'              => $akses
                ];
                return view('admin/lembaga/sambutan/sambutan', $data);
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
                'sambutan' => [
                    'label' => 'Sambutan pimpinan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nama_pimpinan' => [
                    'label' => 'Nama pimpinan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jabatan_pimpinan' => [
                    'label' => 'Jabatan pimpinan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'sambutan'          => $validation->getError('sambutan'),
                        'nama_pimpinan'     => $validation->getError('nama_pimpinan'),
                        'jabatan_pimpinan'  => $validation->getError('jabatan_pimpinan')
                    ]
                ];
            } else {
                $simpandata = [
                    'sambutan'               => $this->request->getVar('sambutan'),
                    'nama_pimpinan'          => $this->request->getVar('nama_pimpinan'),
                    'jabatan_pimpinan'       => $this->request->getVar('jabatan_pimpinan'),
                    'sts_sambutan'           => $this->request->getVar('sts_sambutan')
                ];
                $id_setaplikasi  = $this->request->getVar('id_setaplikasi ');
                $this->konfigurasi->update(1, $simpandata);
                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formuploadpimpinan()
    {
        if ($this->request->isAJAX()) {
            $id_setaplikasi = $this->request->getVar('id_setaplikasi');
            $list = $this->konfigurasi->find($id_setaplikasi);
            $data = [
                'title' => 'Upload Gambar',
                'list'  => $list,
                'id_setaplikasi' => $list['id_setaplikasi']
            ];
            $msg = [
                'sukses' => view('admin/lembaga/sambutan/uploadlogo', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function douploadlogo()
    {
        if ($this->request->isAJAX()) {

            $id_setaplikasi = $this->request->getVar('id_setaplikasi');
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'gbr_sambutan' => [
                    'label' => 'Upload Gambar',
                    'rules' => 'uploaded[gbr_sambutan]|mime_in[gbr_sambutan,image/png,image/jpg,image/jpeg]|is_image[gbr_sambutan]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar',
                        'mime_in' => 'Harus gambar!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'gbr_sambutan' => $validation->getError('gbr_sambutan')
                    ]
                ];
            } else {
                //check
                $cekdata = $this->konfigurasi->find($id_setaplikasi);
                $fotolama = $cekdata['gbr_sambutan'];
                if ($fotolama != '' && file_exists('public/img/konfigurasi/pimpinan/' . $fotolama)) {
                    unlink('public/img/konfigurasi/pimpinan/' . $fotolama);
                }

                $filegambar = $this->request->getFile('gbr_sambutan');
                $nama_file = $filegambar->getRandomName();
                $updatedata = [
                    'gbr_sambutan' => $nama_file,
                ];

                $this->konfigurasi->update($id_setaplikasi, $updatedata);
                // $filegambar->move('public/img/konfigurasi/pimpinan');
                \Config\Services::image()
                    ->withFile($filegambar)
                    ->fit(215, 230, 'center')
                    ->save('public/img/konfigurasi/pimpinan/' . $nama_file, 65);
                $msg = [
                    'sukses' => 'Gambar berhasil diupload!',
                ];
            }
            echo json_encode($msg);
        }
    }
}
