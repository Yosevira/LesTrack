<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    // app/Models/UserModel.php
protected $allowedFields = ['email', 'password', 'nama_ortu', 'nama_anak', 'kelas', 'alamat', 'no_telp', 'role']; // Pastikan 'kelas' ada di sini
}