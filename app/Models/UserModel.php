<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = [
        'email', 'password', 'nama_anak', 'nama_ortu', 'alamat', 'no_telp', 'role'
    ];
}