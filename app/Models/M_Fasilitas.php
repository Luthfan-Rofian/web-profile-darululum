<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Fasilitas extends Model
{
    protected $table      = 'fasilitas';
    protected $primaryKey = 'fasilitas_id';
    protected $allowedFields = ['fasilitas', 'cover_foto', 'ket', 'lokasi', 'sts'];

    //backend
    public function list()
    {
        return $this->table('fasilitas')
            ->orderBy('fasilitas_id', 'DESC')
            ->get()->getResultArray();
    }


    // frontend fasilitas home
    public function listfasilitaspage()
    {
        return $this->table('fasilitas')
            ->where('sts', 0)
            ->orderBy('fasilitas_id', 'DESC');
    }



    public function getaktif()
    {
        return $this->table('fasilitas')
            ->like('sts', '1')
            // ->orderBy('fasilitas_id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('fasilitas')
            ->where('sts', 0)
            ->orderBy('fasilitas_id', 'DESC')
            ->get()->getResultArray();
    }



    // view detail halaman
    public function getutama()
    {
        return $this->table('fasilitas')

            ->where('sts', '1')
            ->get()->getRow();
    }

    public function resetstatus()
    {
        $this->db->table('fasilitas')
            ->update(['sts' => 0]);
    }
}
