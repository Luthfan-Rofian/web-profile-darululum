<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSubMenu extends Model
{
    protected $table      = 'submenu';
    protected $primaryKey = 'submenu_id';
    protected $allowedFields = [
        'menu_id', 'nama_submenu', 'link_submenu', 'iconsm', 'urutansm',
        'targetsm', 'linkexternalsm', 'stssubmenu', 'parentsm'
    ];

    //backend
    public function list()
    {
        return $this->table('submenu')
            ->join('menu', 'menu.menu_id = submenu.menu_id')
            ->orderBy('submenu.urutansm', 'ASC')
            ->get()->getResultArray();
    }
    public function listbyutm($menu_id)
    {
        return $this->table('submenu')
            ->join('menu', 'menu.menu_id = submenu.menu_id')
            ->where('submenu.menu_id', $menu_id)
            ->orderBy('submenu.urutansm', 'ASC')
            ->get()->getResultArray();
    }

    public function getaktif()
    {
        return $this->table('submenu')
            ->like('stssubmenu', '1')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('submenu')
            ->where('stssubmenu', 0)
            ->get()->getResultArray();
    }
}
