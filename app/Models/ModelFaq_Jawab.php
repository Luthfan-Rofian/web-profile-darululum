<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelFaq_Jawab extends Model
{
    protected $table      = 'faq_jawab';
    protected $primaryKey = 'faq_jawabid';
    protected $allowedFields = [
        'faq_tanyaid', 'faq_jawaban', 'nilai'
    ];


    public function listjawaban($faq_tanyaid)
    {
        return $this->table('faq_jawab')
            ->join('faq_tanya', 'faq_tanya.faq_tanyaid = faq_jawab.faq_tanyaid')
            ->where('faq_jawab.faq_tanyaid', $faq_tanyaid)
            ->orderBy('faq_jawabid', 'ASC')
            ->get()->getResultArray();
    }
}
