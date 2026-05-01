<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSurveyJawaban extends Model
{
    protected $table      = 'survey_jawaban';
    protected $primaryKey = 'jawaban_id';
    protected $allowedFields = [
        'pertanyaan_id', 'jawaban', 'nilai'
    ];


    public function listjawaban($pertanyaan_id)
    {
        return $this->table('survey_jawaban')
            ->join('survey_pertanyaan', 'survey_pertanyaan.pertanyaan_id = survey_jawaban.pertanyaan_id')
            ->where('survey_jawaban.pertanyaan_id', $pertanyaan_id)
            ->orderBy('jawaban_id', 'ASC')
            ->get()->getResultArray();
    }

    public function listjawabanx()
    {
        return $this->table('survey_jawaban')
            ->join('survey_pertanyaan', 'survey_pertanyaan.pertanyaan_id = survey_jawaban.pertanyaan_id')
            // ->where('survey_jawaban.pertanyaan_id', $pertanyaan_id)
            ->orderBy('jawaban_id', 'ASC')
            ->get()->getRowArray();
    }
}
