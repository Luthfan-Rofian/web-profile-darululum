<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBeritaTag extends Model
{
    protected $table      = 'berita_tag';
    protected $primaryKey = 'beritatag_id';
    protected $allowedFields = ['berita_id', 'tag_id'];

    //backend beritatag_id

    public function listtag($berita_id)
    {
        return $this->table('berita_tag')
            ->where('berita_id', $berita_id)
            ->get()->getResultArray();
    }

    // front detail berita
    public function listberitatag($berita_id)
    {
        return $this->table('berita_tag')
            ->join('tag', 'tag.tag_id = berita_tag.tag_id')
            ->where('berita_id', $berita_id)
            ->orderBy('beritatag_id', 'DESC')
            ->get()->getResultArray();
    }
}
