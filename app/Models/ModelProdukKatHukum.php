<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProdukKatHukum extends Model
{
    protected $table      = 'produk_kathukum';
    protected $primaryKey = 'kathukum_id';
    protected $allowedFields = [
        'produk_id', 'nama_kathukum', 'file_kathukum', 'tanggal_kathukum',
        'status_kathukum', 'skathukum', 'hits'
    ];


    public function listprodukkathukum($produk_id)
    {
        return $this->table('produk_kathukum')
            ->join('produk_hukum', 'produk_hukum.produk_id = produk_kathukum.produk_id')
            ->where('produk_kathukum.produk_id', $produk_id)
            ->orderBy('kathukum_id', 'ASC')
            ->get()->getResultArray();
    }

    public function listsubprodukhukum()
    {
        return $this->table('produk_kathukum')
            ->join('produk_hukum', 'produk_hukum.produk_id = produk_kathukum.produk_id')
            // ->where('produk_kathukum.produk_id', $produk_id)
            ->orderBy('kathukum_id', 'ASC')
            ->get()->getResultArray();
    }
}
