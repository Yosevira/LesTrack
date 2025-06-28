<?php

namespace App\Models;

use CodeIgniter\Model;

class TugasModel extends Model
{
    protected $table = 'tugas';
    protected $allowedFields = ['user_id', 'mapel', 'deadline', 'keterangan', 'status', 'file'];
}