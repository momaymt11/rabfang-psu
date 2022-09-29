<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointment';
    protected $primaryKey = 'a_id';
    protected $allowedFields = ['a_id', 'a_u_id', 'a_psy_id', 'a_topic', 'a_date'];
}
