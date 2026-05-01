<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSection extends Model
{
    protected $table      = 'section';
    protected $primaryKey = 'section_id';
    protected $allowedFields = ['nama_section', 'gambar', 'link', 'linksumber'];

    //backend
    public function list()
    {
        return $this->table('section')
            ->orderBy('section_id', 'ASC')
            ->get()->getResultArray();
    }
}
