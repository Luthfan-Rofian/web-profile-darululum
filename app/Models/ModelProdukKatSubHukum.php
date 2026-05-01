<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProdukKatSubHukum extends Model
{
    protected $table      = 'produk_subkathukum';
    protected $primaryKey = 'subkathukum_id';
    protected $allowedFields = [
        'kathukum_id', 'nama_subkathukum', 'file_subkathukum', 'tanggal_subkathukum',
        'status_subkathukum', 'hits'
    ];


    public function listprodukkatsubhukum($kathukum_id)
    {
        return $this->table('produk_subkathukum')
            ->join('produk_kathukum', 'produk_kathukum.kathukum_id = produk_subkathukum.kathukum_id')
            ->where('produk_subkathukum.kathukum_id', $kathukum_id)
            ->orderBy('subkathukum_id', 'ASC')
            ->get()->getResultArray();
    }

    // FRONT
    public function listproduksubsubhukum()
    {
        return $this->table('produk_subkathukum')
            ->join('produk_kathukum', 'produk_kathukum.kathukum_id = produk_subkathukum.kathukum_id')
            // ->where('produk_subkathukum.kathukum_id', $kathukum_id)
            ->orderBy('subkathukum_id', 'ASC')
            ->get()->getResultArray();
    }
}
