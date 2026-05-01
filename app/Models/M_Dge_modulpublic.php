<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Dge_modulpublic extends Model
{
    protected $table      = 'cms__modpublic';
    protected $primaryKey = 'id_modpublic';
    protected $allowedFields = ['modpublic', 'link', 'stsmod'];

    //backend
    public function list()
    {
        return $this->table('cms__modpublic')
            ->orderBy('id_modpublic', 'ASC')
            ->get()->getResultArray();
    }

    // add menu, sub menu etc
    public function listaktif()
    {
        return $this->table('cms__modpublic')
            ->where('stsmod', '1')
            ->orderBy('id_modpublic', 'ASC')
            ->get()->getResultArray();
    }

    public function getaktif()
    {
        return $this->table('cms__modpublic')
            ->where('stsmod', '1')
            ->orderBy('id_modpublic', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('cms__modpublic')
            ->where('stsmod', 0)
            ->orderBy('id_modpublic', 'ASC')
            ->get()->getResultArray();
    }
}
