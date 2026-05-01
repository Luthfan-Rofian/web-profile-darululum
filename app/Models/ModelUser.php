<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'email', 'username', 'opd_id', 'id_grup', 'fullname', 'user_image',
        'password_hash', 'active', 'level',
        'activate_hash', 'reset_hash', 'reset_expires', 'last_login', 'sts_on', 'login_attempts'

    ];

    //backend
    public function list()
    {
        return $this->table('users')
            // ->join('custome__opd', 'custome__opd.opd_id = users.opd_id')
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }

    public function listaddnews($id)
    {
        return $this->table('users')
            // ->join('custome__opd', 'custome__opd.opd_id = users.opd_id')
            ->where('active', 1)
            // ->where('id !=', $id)
            // ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }


    public function listbyid($id)
    {
        return $this->table('users')
            // ->join('custome__opd', 'custome__opd.opd_id = users.opd_id')
            ->where('id', $id)
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }


    public function getaktif()
    {
        return $this->table('users')
            ->like('active', '1')
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('users')
            ->where('active', 0)
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }

    public function getonline()
    {
        return $this->table('users')
            ->where('sts_on', 1)
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }

    public function getaktif5()
    {
        return $this->table('users')
            ->like('active', '1')
            ->orderBy('last_login', 'DESC')
            ->get(5, 0)->getResultArray();
    }

    public function getonline5($id)
    {
        return $this->table('users')
            ->where('sts_on', 1)
            ->where('id !=', $id)
            ->orderBy('id', 'ASC')
            ->get(5, 0)->getResultArray();
    }

    public function resetstatus()
    {
        $this->db->table('users')
            ->update(['sts_on' => 0]);
    }


    function kunjungan()
    {
        $ip      = $_SERVER['REMOTE_ADDR'];
        $date = date("Y-m-d");
        $waktu   = time();
        $timeinsert = date("Y-m-d H:i:s");
        $builder = $this->db->table('visitor');
        $cekk = $this->db->query("SELECT * FROM visitor WHERE ip='$ip' AND tgl='$date'");
        $rowh = $cekk->getRowArray();
        if ($cekk->getNumRows() == 0) {
            $datadb = array('ip' => $ip, 'tgl' => $date, 'hits' => '1', 'online' => $waktu, 'time' => $timeinsert);
            $builder->insert($datadb);
        } else {
            $hitss = $rowh['hits'] + 1;
            $datadb = array('ip' => $ip, 'tgl' => $date, 'hits' => $hitss, 'online' => $waktu, 'time' => $timeinsert);
            $array = array('ip' => $ip, 'tgl' => $date);
            $builder->where($array);
            $builder->update($datadb);
        }
    }

    public function totonline()
    {
        $bataswaktu = time() - 300;
        $builder = $this->db->table('visitor');
        $builder->where('online >', $bataswaktu);
        $query = $builder->get();
        return $query->getNumRows();
    }
}
