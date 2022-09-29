<?php

namespace App\Models;

use CodeIgniter\Model;

class SatisfactionModel extends Model
{
    protected $table = 'satisfaction';
    protected $primaryKey = 's_id';
    protected $allowedFields = ['s_id', 's_name', 's_email', 's_datetime'];
}
