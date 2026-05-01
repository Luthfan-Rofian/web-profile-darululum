<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategoriVideo extends Model
{
    protected $table      = 'kategori_video';
    protected $primaryKey = 'kategorivideo_id';
    protected $allowedFields = ['nama_kategori_video', 'slug_kategori_video'];

    //backend
    public function list()
    {
        return $this->table('kategori_video')
            ->orderBy('kategorivideo_id', 'ASC')
            ->get()->getResultArray();
    }
}
