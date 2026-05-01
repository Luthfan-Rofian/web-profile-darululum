<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategori extends Model
{
    protected $table      = 'kategori';
    protected $primaryKey = 'kategori_id';
    protected $allowedFields = ['nama_kategori', 'slug_kategori'];

    //backend
    public function list()
    {
        return $this->table('kategori')
            ->orderBy('kategori_id', 'ASC')
            ->where('kategori_id !=', '0')
            ->get()->getResultArray();
    }

    public function totkategori()
    {
        return $this->table('kategori')
            ->where('kategori_id !=', '0')
            ->get()->getNumRows();
    }
}
