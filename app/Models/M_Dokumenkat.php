<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Dokumenkat extends Model
{
    protected $table      = 'custome__katdok';
    protected $primaryKey = 'id_katdok';
    protected $allowedFields = ['nama_katdok'];


    public function list()
    {
        return $this->table('custome__katdok')
            ->orderBy('id_katdok', 'ASC')
            ->get()->getResultArray();
    }
}
