<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCounter extends Model
{
    protected $table      = 'counter';
    protected $primaryKey = 'id_counter';
    protected $allowedFields = [
        'nm', 'jm', 'ic', 'sumber', 'link', 'sts', 'bgc'
    ];

    //backend
    // public function list()
    // {
    //     return $this->table('tbl_setaplikasi')
    //         ->orderBy('id_setaplikasi', 'ASC')
    //         ->get()->getResultArray();
    // }

    public function list()
    {
        return $this->table('counter')
            ->orderBy('id_counter', 'ASC')
            ->get()->getResultArray();
    }

    public function listfront()
    {
        return $this->table('counter')
            ->where('sts =', '1')
            ->orderBy('id_counter', 'ASC')
            ->get()->getResultArray();
    }

    public function getaktif()
    {
        return $this->table('counter')
            ->where('sts', '1')
            ->orderBy('id_counter', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('counter')
            ->where('sts', '0')
            ->orderBy('id_counter', 'ASC')
            ->get()->getResultArray();
    }
}
