<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransparanDetail extends Model
{
    protected $table      = 'transparan_detail';
    protected $primaryKey = 'transparandetail_id';
    protected $allowedFields = [
        'transparan_id', 'transparan_nama', 'transparan_jumlah',

    ];

    //backend
    public function list($transparan_id)
    {
        return $this->table('transparan_detail')
            ->join('transparan', 'transparan.transparan_id = transparan_detail.transparan_id')
            ->where('transparan_detail.transparan_id', $transparan_id)
            // ->orderBy('submenu.urutansm', 'ASC')
            ->get()->getResultArray();
    }

    public function grafikpendapatan($tahun, $judul)
    {
        return $this->table('transparan_detail')
            ->join('transparan', 'transparan.transparan_id = transparan_detail.transparan_id')
            ->where('transparan.judul', $judul)
            ->where('transparan.tahun', $tahun)
            ->get()->getResultArray();
    }

    public function grafikawal()
    {
        return $this->table('transparan_detail')
            ->join('transparan', 'transparan.transparan_id = transparan_detail.transparan_id')
            ->where('transparan.sts', '1')
            ->where('transparan.vawal', '1')
            ->get()->getResultArray();
    }
}
