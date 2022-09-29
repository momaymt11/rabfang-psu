<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table = 'chat';
    protected $primaryKey = 'c_id';
    protected $allowedFields = ['c_id', 'c_a_id', 'c_u_id', 'c_psy_id', 'c_text', 'c_datetime'];
}
