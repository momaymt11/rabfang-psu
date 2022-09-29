<?php

namespace App\Models;

use CodeIgniter\Model;

class MentalhealthFormModel extends Model
{
    protected $table = 'mentalhealth_form';
    protected $primaryKey = 'm_f_id';
    protected $allowedFields = ['m_f_id', 'm_f_question'];
}
