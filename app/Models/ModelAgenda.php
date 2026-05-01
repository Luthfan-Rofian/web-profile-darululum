<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAgenda extends Model
{
    protected $table      = 'agenda';
    protected $primaryKey = 'agenda_id';
    protected $allowedFields = [
        'tema', 'slug_tema', 'gambar', 'isi_agenda', 'tempat',
        'pengirim', 'tgl_mulai', 'tgl_selesai', 'tgl_posting', 'jam', 'hits', 'id', 'sts'
    ];

    //backend
    public function listagenda()
    {
        return $this->table('agenda')
            ->join('users', 'users.id = agenda.id')
            ->orderBy('agenda_id', 'DESC')
            ->get()->getResultArray();
    }

    public function listagendaauthor($id)
    {
        return $this->table('agenda')
            ->join('users', 'users.id = agenda.id')
            ->orderBy('agenda_id', 'DESC')
            ->where('agenda.id', $id)
            ->get()->getResultArray();
    }

    //frontend agenda
    public function listagendapage()
    {
        $hriini = date("Y-m-d");
        // $tgl    = date("Y-m-d");
        return $this->table('agenda')
            ->join('users', 'users.id = agenda.id')
            // ->where('tgl_mulai >=', $hriini)
            // ->where('tgl_selesai >=', $hriini)
            ->orderBy('agenda_id', 'DESC');
    }


    public function totagenda()
    {
        return $this->table('agenda')
            // ->where(array('type'    => '1'))
            ->get()->getNumRows();
    }
}
