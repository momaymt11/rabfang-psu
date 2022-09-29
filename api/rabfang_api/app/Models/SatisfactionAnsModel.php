<?php

namespace App\Models;

use CodeIgniter\Model;

class SatisfactionAnsModel extends Model
{
    protected $table = 'satisfaction_ans';
    protected $primaryKey = 's_a_id';
    protected $allowedFields = ['s_a_id', 's_a_s_id', 's_a_q_id', 's_a_q_value'];
}
