<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategoriFoto extends Model
{
    protected $table      = 'kategori_foto';
    protected $primaryKey = 'kategorifoto_id';
    protected $allowedFields = ['nama_kategori_foto', 'slug_kategori_foto', 'cover_foto', 'ket', 'tgl_album'];

    //backend
    public function list()
    {
        return $this->table('kategori_foto')
            ->orderBy('kategorifoto_id', 'ASC')
            ->get()->getResultArray();
    }

    // frontend foto home
    public function listalbumpage()
    {
        return $this->table('kategori_foto')
            ->orderBy('kategori_foto.kategorifoto_id', 'DESC');
    }

    public function listalbumlain($kategorifoto_id)
    {
        return $this->table('kategori_foto')
            ->where('kategorifoto_id !=', $kategorifoto_id)
            ->orderBy('kategori_foto.kategorifoto_id', 'RAND');
    }

    public function totdetfotoc($kategorifoto_id)
    {
        return $this->table('foto')

            ->join('foto', 'foto.kategorifoto_id = kategori_foto.kategorifoto_id', 'right')
            ->where('kategori_foto.kategorifoto_id', $kategorifoto_id)
            ->get()->getNumRows();
    }
}
