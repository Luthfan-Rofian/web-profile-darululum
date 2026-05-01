<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSubsubMenu extends Model
{
    protected $table      = 'subsubmenu';
    protected $primaryKey = 'subsubmenu_id';
    protected $allowedFields = [
        'submenu_id', 'nama_subsubmenu', 'link_subsubmenu', 'iconssm', 'urutanssm',
        'targetssm', 'linkexternalssm', 'stsssm'
    ];

    //backend

    public function listbysub($submenu_id)
    {
        return $this->table('subsubmenu')
            ->join('submenu', 'submenu.submenu_id = subsubmenu.submenu_id')
            ->where('subsubmenu.submenu_id', $submenu_id)
            ->orderBy('subsubmenu.urutanssm', 'ASC')
            ->get()->getResultArray();
    }

    public function getaktif()
    {
        return $this->table('subsubmenu')
            ->like('stsssm', '1')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('subsubmenu')
            ->where('stsssm', 0)
            ->get()->getResultArray();
    }
}
