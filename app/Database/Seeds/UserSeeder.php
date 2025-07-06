<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID'); // untuk nama dan alamat Indonesia

        for ($i = 0; $i < 15; $i++) {
            $data = [
                'email'      => $faker->unique()->email,
                'password'   => password_hash('12345678', PASSWORD_BCRYPT), // default password
                'nama_ortu'  => $faker->name,
                'nama_anak'  => $faker->firstName,
                'kelas'      => $faker->randomElement(['1A', '2B', '3C', '4D']),
                'alamat'     => $faker->address,
                'no_telp'    => '08' . $faker->numerify('##########'),
                'role'       => 'ortu',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->table('users')->insert($data);
        }
    }
}