<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProdukHukum extends Model
{
    protected $table      = 'produk_hukum';
    protected $primaryKey = 'produk_id';
    protected $allowedFields = ['id', 'nama_produk'];


    //backend
    public function listprodukhukum()
    {
        return $this->table('produk_hukum')
            ->join('users', 'users.id = produk_hukum.id')
            ->orderBy('produk_id', 'ASC')
            ->get()->getResultArray();
    }

    public function listprodukhukumauthor($id)
    {
        return $this->table('produk_hukum')
            ->join('users', 'users.id = produk_hukum.id')
            ->where('produk_hukum.id', $id)
            ->orderBy('produk_id', 'ASC')
            ->get()->getResultArray();
    }

    // fronfend
    public function listprodukhukumpg()
    {
        return $this->table('produk_hukum')
            // ->join('users', 'users.id = produk_hukum.id')
            // ->join('produk_kathukum', 'produk_kathukum.produk_id = produk_hukum.produk_id')
            ->orderBy('produk_hukum.produk_id', 'ASC');
    }

    public function totproduk()
    {
        return $this->table('produk_hukum')
            ->get()->getNumRows();
    }
}
