<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelEbook extends Model
{
    protected $table      = 'ebook';
    protected $primaryKey = 'ebook_id';
    protected $allowedFields = [
        'judul', 'kategoriebook_id', 'tanggal', 'gambar', 'fileebook', 'penulis', 'j_hal', 'hits', 'id', 'status'
    ];

    //backend
    public function listebook()
    {
        return $this->table('ebook')
            ->join('users', 'users.id = ebook.id')
            ->join('kategori_ebook', 'kategori_ebook.kategoriebook_id = ebook.kategoriebook_id')
            ->orderBy('ebook_id', 'DESC')
            ->get()->getResultArray();
    }

    public function listebookauthor($id)
    {
        return $this->table('ebook')
            ->join('users', 'users.id = ebook.id')
            ->join('kategori_ebook', 'kategori_ebook.kategoriebook_id = ebook.kategoriebook_id')
            ->where('ebook.id', $id)
            ->orderBy('ebook_id', 'DESC')
            ->get()->getResultArray();
    }
    //pencarian

    public function cari($keywordcari, $kategori)
    {
        return $this->table('ebook')
            ->join('users', 'users.id = ebook.id')
            ->join('kategori_ebook', 'kategori_ebook.kategoriebook_id = ebook.kategoriebook_id')
            ->like('ebook.judul', $keywordcari)
            ->orlike('ebook.penulis', $keywordcari)
            ->orlike('kategori_ebook.kategoriebook_nama', $kategori)
            ->where('kategori_ebook.kategoriebook_nama', $kategori)
            ->where('ebook.status', 1)
            ->orderBy('ebook.ebook_id', 'DESC')
            ->get()->getResultArray();
    }

    //pencarian kategori ada keyword tdk

    public function carikat($keywordcari, $kategori)
    {
        return $this->table('ebook')
            ->join('users', 'users.id = ebook.id')
            ->join('kategori_ebook', 'kategori_ebook.kategoriebook_id = ebook.kategoriebook_id')
            ->like('ebook.judul', $keywordcari)
            ->like('ebook.penulis', $keywordcari)
            ->like('kategori_ebook.kategoriebook_nama', $kategori)
            ->where('kategori_ebook.kategoriebook_nama', $kategori)
            ->where('ebook.status', 1)
            ->orderBy('ebook.ebook_id', 'DESC')
            ->get()->getResultArray();
    }


    public function carikatkey($keywordcari, $kategori)
    {
        return $this->table('ebook')
            ->join('users', 'users.id = ebook.id')
            ->join('kategori_ebook', 'kategori_ebook.kategoriebook_id = ebook.kategoriebook_id')
            ->like('ebook.judul', $keywordcari)
            ->orlike('ebook.penulis', $keywordcari)
            ->like('kategori_ebook.kategoriebook_nama', $kategori)
            ->where('kategori_ebook.kategoriebook_nama', $kategori)
            ->where('ebook.status', 1)
            ->orderBy('ebook.ebook_id', 'DESC')
            ->get()->getResultArray();
    }

    // frontend ebook home
    public function listebookpage()
    {
        return $this->table('ebook')
            ->join('users', 'users.id = ebook.id')
            ->join('kategori_ebook', 'kategori_ebook.kategoriebook_id = ebook.kategoriebook_id')
            ->where('status', 1)
            ->orderBy('ebook_id', 'DESC');
    }

    public function totebook()
    {
        return $this->table('ebook')
            ->where('status', 1)
            ->get()->getNumRows();
    }
    // detail ebook
    public function detail($fileebook)
    {
        return $this->table('ebook')

            ->join('users', 'users.id = ebook.id')
            ->join('kategori_ebook', 'kategori_ebook.kategoriebook_id = ebook.kategoriebook_id')
            ->where('fileebook', $fileebook)
            ->orderBy('ebook_id', 'DESC')
            ->get()->getRowArray();
    }

    public function getaktif()
    {
        return $this->table('ebook')
            ->like('status', '1')
            ->orderBy('ebook_id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('ebook')
            ->where('status', '0')
            ->orderBy('ebook_id', 'ASC')
            ->get()->getResultArray();
    }
}
