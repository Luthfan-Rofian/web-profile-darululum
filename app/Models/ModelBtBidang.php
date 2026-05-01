<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBtBidang extends Model
{
    protected $table      = 'bt_bidang';
    protected $primaryKey = 'bidang_id';
    protected $allowedFields = ['nama_bidang'];

    //backend
    public function list()
    {
        return $this->table('bt_bidang')
            ->orderBy('bidang_id', 'ASC')
            // ->where('bidang_id !=', '0')
            ->get()->getResultArray();
    }

    public function totbidang()
    {
        return $this->table('bt_bidang')
            // ->where('bidang_id !=', '0')
            ->get()->getNumRows();
    }
}
