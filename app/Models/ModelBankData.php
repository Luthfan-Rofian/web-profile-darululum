<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBankData extends Model
{
    protected $table      = 'bankdata';
    protected $primaryKey = 'bankdata_id';
    protected $allowedFields = [
        'nama_bankdata', 'fileupload', 'slug_bank', 'tgl_upload', 'hits', 'id', 'sts', 'ket'
    ];

    //backend
    public function listbankdata()
    {
        return $this->table('bankdata')
            ->join('users', 'users.id = bankdata.id')
            ->orderBy('bankdata_id', 'DESC')
            ->get()->getResultArray();
    }

    public function listbankdataauthor($id)
    {
        return $this->table('bankdata')
            ->join('users', 'users.id = bankdata.id')
            ->orderBy('bankdata_id', 'DESC')
            ->where('bankdata.id', $id)
            ->get()->getResultArray();
    }

    public function listbankdatapage()
    {
        return $this->table('bankdata')
            ->join('users', 'users.id = bankdata.id')
            ->orderBy('bankdata_id', 'DESC');
    }

    //frontend bankdata
    public function published()
    {
        return $this->table('bankdata')
            ->join('users', 'users.id = bankdata.id')
            ->orderBy('bankdata_id', 'DESC')
            ->get(6, 0)->getResultArray();
    }
}
