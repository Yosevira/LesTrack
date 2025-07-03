<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KelasToUsers extends Migration
{
    public function up()
    {
        // Menambahkan kolom 'kelas' ke tabel 'users'
        $this->forge->addColumn('users', [
            'kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true, // Mengizinkan kolom ini NULL
                'after'      => 'nama_anak', // Opsional: Menempatkan setelah kolom 'nama_anak'
            ],
        ]);
    }

    public function down()
    {
        // Menghapus kolom 'kelas' dari tabel 'users' jika migrasi di-rollback
        $this->forge->dropColumn('users', 'kelas');
    }
}