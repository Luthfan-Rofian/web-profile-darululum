<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelFoto extends Model
{
    protected $table      = 'foto';
    protected $primaryKey = 'foto_id';
    protected $allowedFields = [
        'judul', 'kategorifoto_id', 'tanggal', 'gambar', 'id', 'hits'
    ];

    //backend
    public function listfoto()
    {
        return $this->table('foto')
            ->join('users', 'users.id = foto.id')
            ->join('kategori_foto', 'kategori_foto.kategorifoto_id = foto.kategorifoto_id')
            ->orderBy('foto_id', 'DESC')
            ->get()->getResultArray();
    }

    public function listfotoid($id)
    {
        return $this->table('foto')
            ->join('users', 'users.id = foto.id')
            ->join('kategori_foto', 'kategori_foto.kategorifoto_id = foto.kategorifoto_id')
            ->where('foto.id', $id)
            ->orderBy('foto_id', 'DESC')
            ->get()->getResultArray();
    }

    // frontend foto home
    public function listfotopage()
    {
        return $this->table('foto')
            ->join('users', 'users.id = foto.id')
            ->join('kategori_foto', 'kategori_foto.kategorifoto_id = foto.kategorifoto_id')
            ->orderBy('foto_id', 'DESC');
    }

    // jumlah foto
    public function totfoto()
    {
        return $this->table('foto')
            ->get()->getNumRows();
    }

    // view detail foto
    public function detail_foto($kategorifoto_id)
    {
        return $this->table('foto')
            ->join('users', 'users.id = foto.id')
            ->join('kategori_foto', 'kategori_foto.kategorifoto_id = foto.kategorifoto_id')
            ->where('kategori_foto.kategorifoto_id', $kategorifoto_id)
            ->orderBy('foto_id', 'DESC')
            ->get()->getResultArray();
    }

    // view detail foto
    public function detail_fotobyid($kategorifoto_id, $id)
    {
        return $this->table('foto')
            ->join('users', 'users.id = foto.id')
            ->join('kategori_foto', 'kategori_foto.kategorifoto_id = foto.kategorifoto_id')
            ->where('kategori_foto.kategorifoto_id', $kategorifoto_id)
            ->where('foto.id', $id)
            ->get()->getResultArray();
    }

    // jumlah album
    public function jumalbum()
    {
        return $this->table('foto')
            ->join('kategori_foto', 'kategori_foto.kategorifoto_id = foto.kategorifoto_id')
            // ->groupBy('kategori_foto.kategorifoto_id')
            ->get()->getNumRows();
    }
}
