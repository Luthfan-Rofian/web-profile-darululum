<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategoriEbook extends Model
{
    protected $table      = 'kategori_ebook';
    protected $primaryKey = 'kategoriebook_id';
    protected $allowedFields = ['kategoriebook_nama', 'kategoriebook_slug'];

    //backend
    public function list()
    {
        return $this->table('kategori_foto')
            ->orderBy('kategoriebook_id', 'ASC')
            ->get()->getResultArray();
    }
}
