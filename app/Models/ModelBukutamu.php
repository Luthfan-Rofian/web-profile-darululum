<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBukutamu extends Model
{
    protected $table      = 'bt_bukutamu';
    protected $primaryKey = 'bukutamu_id';
    protected $allowedFields = ['bidang_id', 'nama', 'telp', 'instansi', 'keperluan', 'status', 'tanggal'];

    //backend
    public function list()
    {
        return $this->table('bt_bukutamu')
            ->orderBy('bukutamu_id', 'DESC')
            ->join('bt_bidang', 'bt_bidang.bidang_id = bt_bukutamu.bidang_id')
            // ->where('bukutamu_id !=', '0')
            ->get()->getResultArray();
    }

    public function totbidang()
    {
        return $this->table('bt_bukutamu')
            // ->where('bukutamu_id !=', '0')
            ->get()->getNumRows();
    }
}
