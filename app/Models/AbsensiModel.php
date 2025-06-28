<?php

namespace App\Models;
use CodeIgniter\Model;

class AbsensiModel extends Model
{
protected $table = 'absensi';
protected $allowedFields = ['user_id', 'tanggal', 'status'];
}