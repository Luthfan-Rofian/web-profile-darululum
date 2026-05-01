<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBanner extends Model
{

    protected $table      = 'tbl_banner';
    protected $primaryKey = 'id_banner';
    protected $allowedFields = ['banner_image', 'ket', 'type', 'link', 'posisi'];

    //backend end banner
    public function list()
    {
        return $this->table('tbl_banner')
            ->orderBy('id_banner', 'DESC')
            ->where('type', '0')
            ->get()->getResultArray();
    }
    //backend end infografis

    public function listgrafis()
    {
        return $this->table('tbl_banner')
            ->orderBy('id_banner', 'DESC')
            ->where('type', '1')
            ->get(6, 0)->getResultArray();
    }

    public function listiklan()
    {
        return $this->table('tbl_banner')
            ->orderBy('id_banner', 'DESC')
            ->where('type', '2')
            ->get()->getResultArray();
    }


    public function listiklantengah()
    {
        return $this->table('tbl_banner')
            ->orderBy('id_banner', 'DESC')
            ->where('type', '2')
            ->where('posisi', '1')
            ->get()->getResultArray();
    }
    public function listiklankanan()
    {
        return $this->table('tbl_banner')
            ->orderBy('id_banner', 'DESC')
            ->where('type', '2')
            ->where('posisi', '2')
            ->get()->getResultArray();
    }
    public function listiklanatas()
    {
        return $this->table('tbl_banner')
            ->orderBy('id_banner', 'DESC')
            ->where('type', '2')
            ->where('posisi', '3')
            ->get()->getResultArray();
    }
    public function listiklankanan1()
    {
        return $this->table('tbl_banner')
            ->where('type', '2')
            ->where('posisi', '4')
            ->orderBy('id_banner', 'RANDOM')
            ->get(1, 0)->getResultArray();
    }

    public function listiklankanan2()
    {
        return $this->table('tbl_banner')
            ->where('type', '2')
            ->where('posisi', '5')
            ->orderBy('id_banner', 'RANDOM')
            ->get(2, 0)->getResultArray();
    }


    public function listiklankanan3()
    {
        return $this->table('tbl_banner')
            ->where('type', '2')
            ->where('posisi', '6')
            ->orderBy('id_banner', 'RANDOM')
            ->get(1, 0)->getResultArray();
    }
    public function iklanstikkiri()
    {
        return $this->table('tbl_banner')
            ->where('type', '2')
            ->where('posisi', '7')
            ->orderBy('id_banner', 'RANDOM')
            ->get(1, 0)->getResultArray();
    }

    public function iklanstikkanan()
    {
        return $this->table('tbl_banner')
            ->where('type', '2')
            ->where('posisi', '8')
            ->orderBy('id_banner', 'RANDOM')
            ->get(1, 0)->getResultArray();
    }


    //front infografis 2
    public function listinfo()
    {
        return $this->table('tbl_banner')
            ->orderBy('id_banner', 'DESC')
            ->where('type', '1')
            ->get(2, 0)->getResultArray();
    }

    //front infografis 1
    public function listinfo1()
    {
        return $this->table('tbl_banner')
            ->orderBy('id_banner', 'DESC')
            ->where('type', '1')
            ->get(1, 2)->getResultArray();
    }

    public function listinfopage()
    {
        return $this->table('tbl_banner')
            ->orderBy('id_banner', 'DESC')
            ->where('type', '1');
    }

    public function totinfografis()
    {
        return $this->table('tbl_banner')
            ->where('type', '1')
            ->get()->getNumRows();
    }
}
