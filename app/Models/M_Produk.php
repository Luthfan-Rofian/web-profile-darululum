<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Produk extends Model
{
    protected $table      = 'custome__lapak';
    protected $primaryKey = 'id_lapak';
    protected $allowedFields = ['nama_lapak', 'harga', 'stok', 'ket', 'tgl', 'sts', 'cover'];

    //backend
    public function list()
    {
        return $this->table('custome__lapak')
            ->orderBy('id_lapak', 'DESC')
            ->get()->getResultArray();
    }

    // frontend fasilitas home
    public function listfasilitaspage()
    {
        return $this->table('custome__lapak')
            ->where('sts', 0)
            ->orderBy('id_lapak', 'DESC');
    }



    public function getaktif()
    {
        return $this->table('custome__lapak')
            ->like('sts', '1')
            // ->orderBy('id_lapak', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('custome__lapak')
            ->where('sts', 0)
            ->orderBy('id_lapak', 'DESC')
            ->get()->getResultArray();
    }



    // view detail halaman
    public function getutama()
    {
        return $this->table('custome__lapak')

            ->where('sts', '1')
            ->get()->getRow();
    }

    public function resetstatus()
    {
        $this->db->table('custome__lapak')
            ->update(['sts' => 0]);
    }
}
