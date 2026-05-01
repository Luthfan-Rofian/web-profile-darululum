<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Dge_grupuser extends Model
{
    protected $table      = 'cms__usergrup';
    protected $primaryKey = 'id_grup';
    protected $allowedFields = ['nama_grup', 'jenis', 'created_by', 'ketgrup', 'sts_menu'];

    //backend list data
    public function list()
    {
        return $this->table('cms__usergrup')
            ->orderBy('id_grup', 'ASC')
            ->get()->getResultArray();
    }

    public function listbyid($id_grup)
    {
        return $this->table('cms__usergrup')
            ->where('id_grup', $id_grup)
            ->orderBy('id_grup', 'ASC')
            ->get()->getResultArray();
    }

    public function listedit()
    {
        return $this->table('cms__usergrup')
            ->orderBy('id_grup', 'ASC')
            ->get()->getResultArray();
    }

    // add to user and konfigurasi
    public function listgrups()
    {
        return $this->table('cms__usergrup')
            ->orderBy('id_grup', 'ASC')
            ->where('jenis', '2')
            ->where('sts_menu', '1')
            ->get()->getResultArray();
    }
}
