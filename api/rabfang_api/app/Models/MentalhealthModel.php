<?php

namespace App\Models;

use CodeIgniter\Model;

class MentalhealthModel extends Model
{
    protected $table = 'mentalhealth';
    protected $primaryKey = 'm_id';
    protected $allowedFields = ['m_id', 'm_name', 'm_email', 'm_datetime'];
}
