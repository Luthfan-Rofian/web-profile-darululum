<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSurveyResponden extends Model
{
    protected $table      = 'survey_responden';
    protected $primaryKey = 'responden_id';
    protected $allowedFields = ['survey_id', 'saran', 'tanggal', 'nohp', 'nama'];


    //backend
    public function listresponden($survey_id)
    {
        return $this->table('survey_responden')
            ->join('survey_topik', 'survey_topik.survey_id = survey_responden.survey_id')
            ->where('survey_responden.survey_id', $survey_id)
            ->orderBy('responden_id', 'ASC')
            ->get()->getResultArray();
    }


    public function totresponden()
    {
        return $this->table('survey_responden')
            ->get()->getNumRows();
    }
}
