<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Dge_grupakses extends Model
{
    protected $table      = 'cms__grupakses';
    protected $primaryKey = 'id_grupakses';
    protected $allowedFields = ['id_grup', 'id_modul', 'akses', 'aksesmenu'];

    //backend
    public function list()
    {
        return $this->table('cms__grupakses')
            ->orderBy('id_grup', 'ASC')
            ->get()->getResultArray();
    }

    // cek data akses users
    public function listgrupakses($id_grup, $url)
    {
        return $this->table('cms__grupakses')
            ->join('cms__modul', 'cms__modul.id_modul = cms__grupakses.id_modul')
            ->where('id_grup', $id_grup)
            ->where('urlmenu', $url)
            ->where('hidden', 0)
            ->where('aktif', 1)
            ->get()->getResultArray();
    }


    // form edit grupakses (colapse)
    public function listgrupedit($id_grup)
    {
        return $this->table('cms__grupakses')
            ->join('cms__modul', 'cms__modul.id_modul = cms__grupakses.id_modul', 'left')
            ->where('cms__grupakses.id_grup', $id_grup)
            ->where('hidden', 0)
            ->where('aktif', 1)
            ->groupBy('cms__modul.gm')
            ->orderBy('cms__modul.id_modul', 'ASC')
            ->get()->getResultArray();
    }


    // form edit grupakses (detail colapse)
    public function listgrupaksesedit($id_grup, $gm)
    {
        return $this->table('cms__grupakses')
            ->join('cms__modul', 'cms__modul.id_modul = cms__grupakses.id_modul', 'left')
            ->where('cms__grupakses.id_grup', $id_grup)
            ->where('cms__modul.gm', $gm)
            ->where('hidden', 0)
            ->where('aktif', 1)
            ->orderBy('urut', 'ASC')
            ->get()->getResultArray();
    }



    // cek data akses menu UTAMA
    public function listgrupaksesmenu($id_grup)
    {
        return $this->table('cms__grupakses')
            ->join('cms__modul', 'cms__modul.id_modul = cms__grupakses.id_modul', 'left')
            ->where('id_grup', $id_grup)
            ->where('tipemn', 'utm')
            ->where('aksesmenu', 1)
            ->where('aktif', 1)
            ->orderBy('urut', 'ASC')
            ->get()->getResultArray();
    }

    // cek data akses sub menu
    public function grupaksessubmenu($id_grup, $gm)
    {
        return $this->table('cms__grupakses')
            ->join('cms__modul', 'cms__modul.id_modul = cms__grupakses.id_modul')
            ->where('id_grup', $id_grup)
            ->where('gm', $gm)
            ->where('akses !=', 3)
            ->where('tipemn', 'sm')
            ->where('hidden', 0)
            ->where('aktif', 1)
            ->orderBy('urut', 'ASC')
            ->get()->getResultArray();
    }

    // Edit Menu by grup id
    public function editaksesmenu($id_grup)
    {
        return $this->table('cms__grupakses')
            ->join('cms__modul', 'cms__modul.id_modul = cms__grupakses.id_modul')
            ->where('id_grup', $id_grup)
            ->where('tipemn', 'utm')
            ->where('aktif', 1)
            ->get()->getResultArray();
    }

    // cek id modul baru
    public function totmodul($id_modul)
    {
        return $this->table('cms__grupakses')
            ->where('id_modul', $id_modul)
            ->get()->getNumRows();
    }
    public function listgrupaksesganda($id_grup, $id_modul)
    {
        return $this->table('cms__grupakses')
            // ->join('cms__modul', 'cms__modul.id_modul = cms__grupakses.id_modul')
            ->where('id_grup', $id_grup)
            ->where('id_modul', $id_modul)
            ->get()->getResultArray();
    }
    // CEK UNTUK HAPUS AKSES KETIKA MODUL DIHAPUS
    public function listaksesmodul($id_modul)
    {
        return $this->table('cms__grupakses')
            ->where('id_modul', $id_modul)
            ->get()->getResultArray();
    }
    public function listaksesgrup($id_grup)
    {
        return $this->table('cms__grupakses')
            ->where('id_grup', $id_grup)
            ->get()->getResultArray();
    }
}
