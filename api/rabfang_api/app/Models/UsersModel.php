<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'u_id';
    protected $allowedFields = ['u_id', 'u_image', 'u_name', 'u_email', 'u_password', 'u_faculty', 'u_major', 'u_year', 'u_phone', 'u_birthday', 'u_address'];
}
