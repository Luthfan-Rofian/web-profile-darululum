<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPegawai extends Model
{
    protected $table      = 'pegawai';
    protected $primaryKey = 'pegawai_id';
    protected $allowedFields = [
        'nip', 'nama', 'tempat_lahir', 'tgl_lahir', 'jk',
        'agama', 'pangkat', 'jabatan', 'gambar', 'filetupoksi', 'publikasi', 'penelitian', 'pengabdian', 'asal_s1',
        'asal_s2', 'asal_s3', 'bidang_pakar', 'bio_singkat'
    ];

    //backend
    public function list()
    {
        return $this->table('pegawai')
            ->orderBy('pegawai_id', 'ASC')
            ->get()->getResultArray();
    }

    //pager front
    public function listpegawaipage()
    {
        return $this->table('pegawai')
            ->orderBy('pegawai_id', 'ASC');
    }

    public function totpegawai()
    {
        return $this->table('pegawai')
            // ->where(array('type'    => '1'))
            ->get()->getNumRows();
    }

    public function cekdata($nip)
    {
        return $this->table('pegawai')
            ->where('nip', $nip)
            ->get()->getRowArray();
    }
}
