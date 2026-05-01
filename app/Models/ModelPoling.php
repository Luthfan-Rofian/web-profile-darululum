<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPoling extends Model
{
    protected $table      = 'poling';
    protected $primaryKey = 'poling_id';
    protected $allowedFields = ['pilihan', 'type', 'rating', 'status', 'id'];


    //backend
    public function list()
    {
        return $this->table('poling')
            ->join('users', 'users.id = poling.id')
            ->orderBy('poling_id', 'ASC')
            ->get()->getResultArray();
    }

    //frontend poling pertanyaan
    public function poltanya()
    {
        return $this->table('poling')
            ->join('users', 'users.id = poling.id')
            ->where(array('type' => 'Pertanyaan'))
            ->orderBy('poling_id', 'ASC')
            ->get()->getRowArray();
    }

    //frontend poling pertanyaan
    public function poljawab()
    {
        return $this->table('poling')
            ->join('users', 'users.id = poling.id')
            ->where(array('status'    => 'Y', 'type' => 'Jawaban'))
            ->orderBy('poling_id', 'ASC')
            ->get()->getResultArray();
    }

    public function polling_sum()
    {

        $db      = \Config\Database::connect();
        $builder = $this->db->table('poling');
        $builder->select('(SELECT SUM(poling.rating) FROM poling WHERE poling.status="Y") AS jml_vote', false);

        $query = $builder->get()->getRowArray();
        return $query;
    }


    public function getaktif()
    {
        return $this->table('poling')
            ->like('status', 'Y')
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('poling')
            ->where('status', 'N')
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }
}
