<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Unitkerjatipe extends Model
{
    protected $table      = 'custome__opdtipe';
    protected $primaryKey = 'tipe_id';
    protected $allowedFields = ['nama_tipe'];


    public function list()
    {
        return $this->table('custome__opdtipe')
            ->orderBy('tipe_id', 'ASC')
            ->get()->getResultArray();
    }
}
