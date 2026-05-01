<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTag extends Model
{
    protected $table      = 'tag';
    protected $primaryKey = 'tag_id';
    protected $allowedFields = ['nama_tag', 'slug_tag'];

    //backend
    public function list()
    {
        return $this->table('tag')
            ->orderBy('tag_id', 'ASC')

            ->get()->getResultArray();
    }
    public function listtag()
    {
        return $this->table('tag')
            ->orderBy('tag_id', 'ASC')
            ->get(7, 0)->getResultArray();
    }

    public function tottag()
    {
        return $this->table('tag')

            ->get()->getNumRows();
    }
}
