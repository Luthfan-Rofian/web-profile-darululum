<?php

namespace App\Controllers;

use Ifsnop\Mysqldump\Mysqldump;

class Database extends BaseController
{
    public function index()
    {
        $level = session()->get('level');

        if ($level == 'autor' || $level == 'editor') {

            return redirect()->to(base_url('admin'));
        }


        $list =  $this->konfigurasi->orderBy('id_setaplikasi ')->first();
        $data = [
            'title'              => 'Dashboard',
            'subtitle'           => 'Pengaturan Database',
            'konfigurasi'        => $this->konfigurasi->list(),
            'id_setaplikasi'     => $list['id_setaplikasi'],

            'sts_regis'   => $list['sts_regis'],
            'sts_posting'   => $list['sts_posting'],
            'verbost'   => $list['verbost'],


        ];
        return view('admin/pengaturan/database/database', $data);
    }


    public function migrasidb()
    {
        if ($this->request->isAJAX()) {
            //add colom
            $forge = \Config\Database::forge();

            // $fields = [
            //     'verdb' => [
            //         'type' => 'VARCHAR',
            //         'constraint' => 100,
            //     ]
            // ];
            // $forge->addColumn('tbl_setaplikasi', $fields);

            $forge->dropColumn('tbl_setaplikasi', 'sts_terkini, sts_pilihan'); // by proving comma separated column names

            $msg = [
                'sukses' => 'DB berhasil diupgrade!',
            ];
        }

        echo json_encode($msg);
    }

    public function doBackup()
    {
        if ($this->request->isAJAX()) {
            try {
                $tgl = date('dym');
                $dump = new Mysqldump('mysql:host=localhost;dbname=ci4_cmsdatagoe;port=3306', 'root', '');


                $dump->start('file/db/dbcms-' . $tgl . '.sql');

                $msg = [
                    'sukses' => 'DB berhasil dibackup!',
                ];
            } catch (\Exception $e) {
                // echo 'mysqldump-php error: ' . $e->getMessage();
                $msg = [
                    'error' => 'mysqldump-php error:' . $e->getMessage(),
                ];
            }
        }
        echo json_encode($msg);
    }

    public function doBackupm()
    {
        // if ($this->request->isAJAX()) {
        try {
            $tgl = date('dym');
            $dump = new Mysqldump('mysql:host=localhost;dbname=ci4_cmsdatagoe;port=3306', 'root', '');


            $dump->start('public/file/db/dbcms-' . $tgl . '.sql');

            // $msg = [
            //     'sukses' => 'DB berhasil dibackup!',
            // ];
            $msg = "sukses";
            session()->setFlashdata('msg', $msg);
            return redirect()->to('/database/index');
        } catch (\Exception $e) {
            // echo 'mysqldump-php error: ' . $e->getMessage();
            // $msg = [
            //     'error' => 'mysqldump-php error:' . $e->getMessage(),
            // ];
            $msg = "mysqldump-php error" . $e->getMessage();
            session()->setFlashdata('msg', $msg);
            return redirect()->to('/database/index');
        }
    }
    // echo json_encode($msg);
    // }
}
