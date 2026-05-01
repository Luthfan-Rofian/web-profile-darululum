<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Dge_modul extends Model
{
    protected $table      = 'cms__modul';
    protected $primaryKey = 'id_modul';
    protected $allowedFields = ['modul', 'aktif', 'urut', 'level', 'hidden', 'gm', 'tipemn', 'urlmenu', 'ikonmn',];

    //backend add new grup akses
    public function list()
    {
        return $this->table('cms__modul')
            ->where('hidden', 0)
            ->where('tipemn', 'sm')
            ->orderBy('id_modul', 'DESC')
            ->get()->getResultArray();
    }

    //backend grup add (colapse)
    public function listmodulgrup()
    {
        return $this->table('cms__modul')
            ->where('hidden', 0)
            ->where('aktif', 1)
            ->groupBy('cms__modul.gm')
            ->orderBy('id_modul', 'ASC')
            ->get()->getResultArray();
    }

    //backend add new grup akses (detail calpse)
    public function listbygrup($gm)
    {
        return $this->table('cms__modul')
            ->where('hidden', 0)
            ->where('aktif', 1)
            ->where('tipemn', 'sm')
            ->where('gm', $gm)
            ->orderBy('urut', 'ASC')
            ->get()->getResultArray();
    }

    //backend list all modul by grup 
    public function listbygrupall($gm)
    {
        return $this->table('cms__modul')
            ->where('hidden', 0)
            // ->where('aktif', 1)
            ->where('tipemn', 'sm')
            ->where('gm', $gm)
            ->orderBy('urut', 'ASC')
            ->get()->getResultArray();
    }

    // add menu grup
    public function listmenuutama()
    {
        return $this->table('cms__modul')
            ->where('tipemn', 'utm')
            ->orderBy('urut', 'ASC')
            ->get()->getResultArray();
    }

    // list all backend

    public function listall()
    {
        return $this->table('cms__modul')
            // ->where('hidden', 0)
            ->orderBy('urut', 'ASC')
            ->get()->getResultArray();
    }


    public function getaktif()
    {
        return $this->table('cms__modul')
            ->like('aktif', '1')
            ->orderBy('id_modul', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('cms__modul')
            ->where('aktif', 0)
            ->orderBy('id_modul', 'ASC')
            ->get()->getResultArray();
    }

    // add to menu etc

}
