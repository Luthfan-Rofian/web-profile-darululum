<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransparan extends Model
{
    protected $table      = 'transparan';
    protected $primaryKey = 'transparan_id';
    protected $allowedFields = ['id', 'judul', 'tahun', 'jenis', 'sts', 'vawal'];

    //backend
    public function list()
    {
        return $this->table('transparan')
            ->orderBy('transparan_id', 'DESC')
            ->get()->getResultArray();
    }

    public function listtransauthor($id)
    {
        return $this->table('transparan')
            ->join('users', 'users.id = transparan.id')
            ->orderBy('transparan_id', 'DESC')
            ->where('transparan.id', $id)
            ->get()->getResultArray();
    }

    public function listopsi()
    {
        return $this->table('transparan')
            ->where('sts', 1)
            ->get()->getResultArray();
    }

    public function getaktif()
    {
        return $this->table('transparan')
            ->like('sts', '1')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('transparan')
            ->where('sts', 0)
            ->get()->getResultArray();
    }

    // default tampil


    public function getaktifdef()
    {
        return $this->table('transparan')
            ->like('vawal', '1')
            ->orderBy('transparan_id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktifdef()
    {
        return $this->table('transparan')
            ->where('vawal', 0)
            ->orderBy('transparan_id', 'ASC')
            ->get()->getResultArray();
    }

    public function resetstatus()
    {
        $this->db->table('transparan')
            ->update(['vawal' => 0]);
    }
}
