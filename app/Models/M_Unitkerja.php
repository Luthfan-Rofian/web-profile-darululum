<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Unitkerja extends Model
{
    protected $table      = 'custome__opd';
    protected $primaryKey = 'opd_id';
    protected $allowedFields = [
        'nama_opd', 'deskripsi_opd', 'singkatan_opd', 'alamat', 'tipe_id', 'sts',
    ];


    public function listopd()
    {
        return $this->table('custome__opd')
            ->join('custome__opdtipe', 'custome__opdtipe.tipe_id = custome__opd.tipe_id')
            ->where('opd_id !=', '0')
            ->orderBy('opd_id', 'ASC')
            ->get()->getResultArray();
    }

    public function totopd()
    {
        return $this->table('custome__opd')
            ->where('opd_id !=', '0')
            ->get()->getNumRows();
    }
}
