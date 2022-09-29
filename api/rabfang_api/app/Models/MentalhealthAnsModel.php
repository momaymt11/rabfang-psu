<?php

namespace App\Models;

use CodeIgniter\Model;

class MentalhealthAnsModel extends Model
{
    protected $table = 'mentalhealth_ans';
    protected $primaryKey = 'm_a_id';
    protected $allowedFields = ['m_a_id', 'm_a_m_id', 'm_a_q_id', 'm_a_q_value'];
}
