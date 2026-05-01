<?php

namespace App\Models;

use CodeIgniter\Model;

class M_FasilitasDetail extends Model
{
    protected $table      = 'fasilitas_detail';
    protected $primaryKey = 'fasilitasdetail_id';
    protected $allowedFields = [
        'fasilitas_id', 'gambar', 'deskripsi',

    ];

    //backend
    public function list($fasilitas_id)
    {
        return $this->table('fasilitas_detail')
            ->join('fasilitas', 'fasilitas.fasilitas_id = fasilitas_detail.fasilitas_id')
            ->where('fasilitas_detail.fasilitas_id', $fasilitas_id)
            ->get()->getResultArray();
    }

    // jumlah fasilitas
    public function jumfas()
    {
        return $this->table('fasilitas_detail')
            ->join('fasilitas', 'fasilitas.fasilitas_id = fasilitas_detail.fasilitas_id')
            ->groupBy('fasilitas.fasilitas_id')
            ->get()->getNumRows();
    }
}
