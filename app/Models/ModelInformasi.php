<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelInformasi extends Model
{
    protected $table      = 'informasi';
    protected $primaryKey = 'informasi_id';
    protected $allowedFields = [
        'nama', 'slug_informasi', 'gambar', 'isi_informasi', 'tgl_informasi',
        'hits', 'type', 'id', 'fileunduh', 'sts_aktif'
    ];

    //backend
    public function listlayanan()
    {
        return $this->table('informasi')
            ->join('users', 'users.id = informasi.id')
            ->where('type', '0')
            ->orderBy('informasi_id', 'DESC')
            ->get()->getResultArray();
    }

    public function listlayananauthor($id)
    {
        return $this->table('informasi')
            ->join('users', 'users.id = informasi.id')
            ->where('type', '0')
            ->where('informasi.id', $id)
            ->orderBy('informasi_id', 'DESC')
            ->get()->getResultArray();
    }

    //pager all/info front
    public function listlayananpage()
    {
        return $this->table('informasi')
            ->join('users', 'users.id = informasi.id')
            ->where('type', '0')
            ->orderBy('informasi_id', 'DESC');
    }


    //total layanan back all
    public function totlayanan()
    {
        return $this->table('informasi')
            ->where(array('type'    => '0'))
            ->get()->getNumRows();
    }

    public function totlayananbyid($id)
    {
        return $this->table('informasi')
            ->where(array(
                'type'    => '0',
                'informasi.id'    => $id,

            ))
            ->get()->getNumRows();
    }

    //total pengumuman back

    public function totpengumuman()
    {
        return $this->table('informasi')
            ->where(array(
                'type'    => '1'
            ))
            ->get()->getNumRows();
    }
    public function totpengumumanbyid($id)
    {
        return $this->table('informasi')
            ->where(array(
                'type'    => '1',
                'informasi.id'    => $id
            ))
            ->get()->getNumRows();
    }
    //backend pengumuman
    public function listpengumuman()
    {
        return $this->table('informasi')
            ->join('users', 'users.id = informasi.id')
            ->where('type', '1')
            ->orderBy('informasi_id', 'DESC')
            ->get()->getResultArray();
    }

    public function listpengumumanauthor($id)
    {
        return $this->table('informasi')
            ->join('users', 'users.id = informasi.id')
            ->where('type', '1')
            ->where('informasi.id', $id)
            ->orderBy('informasi_id', 'DESC')
            ->get()->getResultArray();
    }


    //pager all/side/front
    public function listpengumumanpage()
    {
        return $this->table('informasi')
            ->join('users', 'users.id = informasi.id')
            ->where('type', '1')
            ->orderBy('informasi_id', 'DESC');
    }
}
