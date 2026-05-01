<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLinkTerkait extends Model
{
    protected $table      = 'link_terkait';
    protected $primaryKey = 'id_link';
    protected $allowedFields = ['nama_link', 'url', 'gambar', 'status'];

    //backend
    public function list()
    {
        return $this->table('link_terkait')
            ->orderBy('id_link', 'ASC')
            ->get()->getResultArray();
    }


    public function getaktif()
    {
        return $this->table('link_terkait')
            ->like('status', '1')
            ->orderBy('id_link', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('link_terkait')
            ->where('status', 0)
            ->orderBy('id_link', 'ASC')
            ->get()->getResultArray();
    }

    // front per page
    public function listlinkpage()
    {
        return $this->table('informasi')
            ->where('status', '1')
            ->orderBy('id_link', 'ASC');
    }

    //frontend link all
    public function publishlinkall()
    {
        return $this->table('link_terkait')
            ->where('status', '1')
            ->orderBy('id_link', 'ASC')
            ->get()->getResultArray();
    }
}
