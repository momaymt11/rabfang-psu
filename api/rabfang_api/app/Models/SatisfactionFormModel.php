<?php

namespace App\Models;

use CodeIgniter\Model;

class SatisfactionFormModel extends Model
{
    protected $table = 'satisfaction_form';
    protected $primaryKey = 's_f_id';
    protected $allowedFields = ['s_f_id', 's_f_question'];
}
