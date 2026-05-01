<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Dokumen extends Model
{
    protected $table      = 'custome__dokumenupl';
    protected $primaryKey = 'id_dokumenupl';
    protected $allowedFields = [
        'id_katdok', 'id', 'nama_dok', 'ket', 'file_dok', 'sts', 'tgl_upload'
    ];



    public $db;
    public $builder;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // SERVER SIDE

    protected function _get_datatables_query($table, $column_order, $column_search, $order)
    {
        $this->builder = $this->db->table($table);
        $this->builder->join('users', 'users.id = custome__dokumenupl.id');
        $this->builder->join('custome__katdok', 'custome__katdok.id_katdok = custome__dokumenupl.id_katdok', 'left');
        $i = 0;

        foreach ($column_search as $item) {
            if ($_POST['search']['value']) {

                if ($i === 0) {
                    $this->builder->groupStart();
                    $this->builder->like($item, $_POST['search']['value']);
                } else {
                    $this->builder->orLike($item, $_POST['search']['value']);
                }

                if (count($column_search) - 1 == $i)
                    $this->builder->groupEnd();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->builder->orderBy($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->builder->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatables($table, $column_order, $column_search, $order, $data = '')
    {
        $this->_get_datatables_query($table, $column_order, $column_search, $order);
        if ($_POST['length'] != -1)
            $this->builder->limit($_POST['length'], $_POST['start']);
        if ($data) {
            $this->builder->where($data);
        }

        $query = $this->builder->get();
        return $query->getResult();
    }

    public function count_filtered($table, $column_order, $column_search, $order, $data = '')
    {
        $this->_get_datatables_query($table, $column_order, $column_search, $order);
        if ($data) {
            $this->builder->where($data);
        }
        $this->builder->get();
        return $this->builder->countAll();
    }

    public function count_all($table, $data = '')
    {
        if ($data) {
            $this->builder->where($data);
        }
        $this->builder->from($table);

        return $this->builder->countAll();
    }

    // END SERVER SIDE--------------------------------------------------------------



    //backend admin
    public function listdokumen()
    {
        return $this->table('custome__dokumenupl')
            ->join('users', 'users.id = custome__dokumenupl.id')
            ->join('custome__katdok', 'custome__katdok.id_katdok = custome__dokumenupl.id_katdok')
            ->orderBy('id_dokumenupl', 'DESC')
            ->get()->getResultArray();
    }

    public function listdokumenauthor($id)
    {
        return $this->table('custome__dokumenupl')
            ->join('users', 'users.id = custome__dokumenupl.id')
            ->join('custome__katdok', 'custome__katdok.id_katdok = custome__dokumenupl.id_katdok')
            ->orderBy('id_dokumenupl', 'DESC')
            ->where('custome__dokumenupl.id', $id)
            ->get()->getResultArray();
    }

    public function listdokumenpage()
    {
        return $this->table('custome__dokumenupl')
            ->join('users', 'users.id = custome__dokumenupl.id')
            ->join('custome__katdok', 'custome__katdok.id_katdok = custome__dokumenupl.id_katdok')
            ->orderBy('id_dokumenupl', 'DESC');
    }
}
