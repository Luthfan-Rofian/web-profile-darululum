<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTemplate extends Model
{
    protected $table      = 'template';
    protected $primaryKey = 'template_id';
    protected $allowedFields = ['nama', 'pembuat', 'folder', 'status', 'id', 'ket', 'img'];

    //backend
    public function list()
    {
        return $this->table('template')
            ->orderBy('template_id', 'ASC')
            ->get()->getResultArray();
    }

    public function tempaktif()
    {
        return $this->table('template')

            ->orderBy('template_id', 'ASC')
            ->where('status', 1)
            ->get()->getRowArray();
    }


    public function getaktif()
    {
        return $this->table('template')
            ->like('status', '1')
            ->orderBy('template_id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('template')
            ->where('status', 0)
            ->orderBy('template_id', 'ASC')
            ->get()->getResultArray();
    }

    public function resetstatus()
    {
        $this->db->table('template')
            ->update(['status' => 0]);
    }
}
