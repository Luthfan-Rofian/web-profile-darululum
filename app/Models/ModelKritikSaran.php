<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKritikSaran extends Model
{
    protected $table      = 'kritiksaran';
    protected $primaryKey = 'kritiksaran_id';
    protected $allowedFields = [
        'nama', 'email', 'judul', 'isi_kritik', 'tanggal', 'status', 'no_hpusr', 'balas', 'tgl_bls'
    ];

    //backend
    public function list()
    {
        return $this->table('kritiksaran')
            ->orderBy('kritiksaran_id', 'DESC')
            ->get()->getResultArray();
    }

    //backend menu atas
    public function listkritiknew()
    {
        return $this->table('kritiksaran')
            ->where('status', '0')
            ->orderBy('kritiksaran_id', 'DESC')
            ->get(6, 0)->getResultArray();
    }

    //total blm dibaca
    public function totkritik()
    {
        return $this->table('kritiksaran')
            ->where(array('status'    => '0'))
            ->get()->getNumRows();
    }

    //total suara anda
    public function totsuaraanda()
    {
        return $this->table('kritiksaran')
            ->where('status', '2')
            ->get()->getNumRows();
    }

    // suara anda

    public function listsuaraanda()
    {
        return $this->table('kritiksaran')
            ->where('status', '2')
            ->orderBy('kritiksaran_id', 'DESC');
    }


    public function getaktif()
    {
        return $this->table('kritiksaran')
            ->where('status', '2')
            ->orderBy('kritiksaran_id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('kritiksaran')
            ->where('status', 1)
            ->orderBy('kritiksaran_id', 'ASC')
            ->get()->getResultArray();
    }
}
