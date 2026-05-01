<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBeritaKomen extends Model
{
    protected $table      = 'berita_komen';
    protected $primaryKey = 'beritakomen_id';
    protected $allowedFields = ['berita_id', 'id', 'nama_komen', 'hp_komen', 'isi_komen', 'tanggal_komen', 'balas_komen', 'sts_komen', 'email_komen', 'tgl_balas'];

    //backend
    public function list()
    {
        return $this->table('berita_komen')
            ->orderBy('berita_komen.beritakomen_id', 'DESC')
            ->get()->getResultArray();
    }

    //backend beritakomen_id
    public function listkomen($berita_id)
    {
        return $this->table('berita_komen')
            ->where('berita_id', $berita_id)
            ->get()->getResultArray();
    }

    // front detail berita
    public function listberitakomen($berita_id)
    {
        return $this->table('berita_komen')
            ->join('users', 'users.id = berita_komen.id')
            ->where('berita_id', $berita_id)
            ->where('sts_komen', 1)
            ->orderBy('beritakomen_id', 'DESC')
            ->get()->getResultArray();
    }

    //total blm dibaca
    public function totkomen()
    {
        return $this->table('berita_komen')
            ->where('sts_komen', 0)
            ->get()->getNumRows();
    }

    //backend menu atas
    public function listkomennew()
    {
        return $this->table('berita_komen')
            ->join('berita', 'berita.berita_id = berita_komen.berita_id')
            ->orderBy('berita_komen.beritakomen_id', 'DESC')
            ->where('berita_komen.sts_komen', 0)
            ->get(8, 0)->getResultArray();
    }
}
