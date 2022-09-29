<?php

namespace App\Models;

use CodeIgniter\Model;

class PsychiatristModel extends Model
{
    protected $table = 'psychiatrist';
    protected $primaryKey = 'psy_id';
    protected $allowedFields = ['psy_id', 'psy_image', 'psy_name', 'psy_email', 'psy_password', 'psy_lang'];
}
