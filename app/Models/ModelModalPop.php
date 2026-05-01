<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelModalPop extends Model
{
    protected $table      = 'modalpopup';
    protected $primaryKey = 'modalpopup_id';
    protected $allowedFields = [
        'judultawaran', 'isitawaran', 'gbrtawaran',
        'linktawaran', 'namatombol', 'sts_tombol'
    ];

    //backend
    public function list()
    {
        return $this->table('modalpopup')
            ->orderBy('modalpopup_id', 'ASC')
            ->get()->getResultArray();
    }
}
