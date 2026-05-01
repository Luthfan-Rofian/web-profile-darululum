<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSurveyPertanyaan extends Model
{
    protected $table      = 'survey_pertanyaan';
    protected $primaryKey = 'pertanyaan_id';
    protected $allowedFields = [
        'survey_id', 'pertanyaan', 'status'
    ];


    public function listpertanyaan($survey_id)
    {
        return $this->table('survey_pertanyaan')
            ->join('survey_topik', 'survey_topik.survey_id = survey_pertanyaan.survey_id')
            ->where('survey_pertanyaan.survey_id', $survey_id)
            ->orderBy('pertanyaan_id', 'ASC')
            ->get()->getResultArray();
    }

    public function listsubprodukhukum()
    {
        return $this->table('survey_pertanyaan')
            ->join('survey_topik', 'survey_topik.survey_id = survey_pertanyaan.survey_id')
            // ->where('survey_pertanyaan.survey_id', $survey_id)
            ->orderBy('pertanyaan_id', 'ASC')
            ->get()->getResultArray();
    }
}
