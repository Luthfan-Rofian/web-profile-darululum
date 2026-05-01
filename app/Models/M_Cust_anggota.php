<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Cust_anggota extends Model
{
    protected $table      = 'custome__anggota';
    protected $primaryKey = 'anggota_id';
    protected $allowedFields = [
        'nama', 'no_hp', 'tempat_lahir', 'tgl_lahir', 'jk', 'alamat', 'tgl_daftar', 'status', 'nik',
        'provinsi', 'kab', 'kec', 'kel', 'rtrw', 'pekerjaan', 'pendidikan', 'dok_ktp'
    ];

    //backend
    public function list()
    {
        return $this->table('custome__anggota')
            ->orderBy('anggota_id', 'DESC')
            // ->where('anggota_id !=', '0')
            ->get()->getResultArray();
    }

    public function totbidang()
    {
        return $this->table('custome__anggota')
            // ->where('anggota_id !=', '0')
            ->get()->getNumRows();
    }

    public function getaktif()
    {
        return $this->table('custome__anggota')
            ->like('status', '1')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('custome__anggota')
            ->where('status', 0)
            ->get()->getResultArray();
    }
}
