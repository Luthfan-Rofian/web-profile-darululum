<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMenu extends Model
{
    protected $table      = 'menu';
    protected $primaryKey = 'menu_id';
    protected $allowedFields = [
        'nama_menu', 'menu_link', 'parent', 'icon', 'urutan', 'target', 'linkexternal', 'posisi', 'stsmenu'
    ];

    //backend
    public function listmenu()
    {
        return $this->table('menu')
            ->orderBy('urutan', 'ASC')
            ->get()->getResultArray();
    }

    public function listutama($posisi)
    {
        return $this->table('menu')
            ->where('posisi', $posisi)
            ->orderBy('urutan', 'ASC')
            ->get()->getResultArray();
    }


    // mainmenu frontend
    public function mainmenu()
    {
        return $this->table('menu')
            ->where('posisi', '0')
            ->where('stsmenu', '1')
            ->orderBy('urutan', 'ASC')
            ->get()->getResultArray();
    }

    // footer menu frontend
    public function footermenu()
    {
        return $this->table('menu')
            ->where('posisi', '2')
            ->where('stsmenu', '1')
            ->orderBy('urutan', 'ASC')
            ->get()->getResultArray();
    }

    // top menu frontend
    public function topmenu()
    {
        return $this->table('menu')
            ->where('posisi', '1')
            ->where('stsmenu', '1')
            ->orderBy('urutan', 'ASC')
            ->get()->getResultArray();
    }

    public function getaktif()
    {
        return $this->table('menu')
            ->like('stsmenu', '1')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('menu')
            ->where('stsmenu', 0)
            ->get()->getResultArray();
    }
}
