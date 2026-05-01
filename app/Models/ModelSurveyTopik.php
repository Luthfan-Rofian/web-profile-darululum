<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSurveyTopik extends Model
{
    protected $table      = 'survey_topik';
    protected $primaryKey = 'survey_id';
    protected $allowedFields = [
        'id', 'nama_survey', 'status', 'hits', 'skor',
        'r1_stb', 'r2_stb', 'r1_kb', 'r2_kb', 'r1_b', 'r2_b', 'r1_sb', 'r2_sb',
        'ket_stb', 'ket_kb', 'ket_b', 'ket_sb'
    ];


    //backend
    public function listsurveytopik()
    {
        return $this->table('survey_topik')
            ->join('users', 'users.id = survey_topik.id')
            ->orderBy('survey_id', 'ASC')
            ->get()->getResultArray();
    }

    public function listsurveytopikauthor($id)
    {
        return $this->table('survey_topik')
            ->join('users', 'users.id = survey_topik.id')
            ->where('survey_topik.id', $id)
            ->orderBy('survey_id', 'ASC')
            ->get()->getResultArray();
    }

    // fronfend
    public function listsurveytopikpg()
    {
        return $this->table('survey_topik')
            ->join('users', 'users.id = survey_topik.id')
            ->orderBy('survey_id', 'ASC')
            ->where('status', 1);
    }

    public function totsurvey()
    {
        return $this->table('survey_topik')
            ->get()->getNumRows();
    }

    public function listcetak($survey_id)
    {
        return $this->table('survey_topik')
            ->join('users', 'users.id = survey_topik.id')
            ->where('survey_topik.survey_id', $survey_id)
            ->orderBy('survey_id', 'ASC')
            ->get()->getRowArray();
    }

    public function getaktif()
    {
        return $this->table('survey_topik')
            ->like('status', '1')
            ->orderBy('survey_id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('survey_topik')
            ->where('status', 0)
            ->orderBy('survey_id', 'ASC')
            ->get()->getResultArray();
    }

    public function resetdata()
    {
        $this->db->table('survey_topik')
            ->update(['status' => 0]);
    }
}
