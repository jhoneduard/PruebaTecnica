<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 12345,
            'nombre' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Admin12345'),
            'created_at' => '2022-02-11 20:42:17',
            'id_role' => 1
        ]);

        DB::table('users')->insert([
            'id' => 67890,
            'nombre' => 'User Normal',
            'email' => 'usernormal@gmail.com',
            'password' => bcrypt('User12345'),
            'created_at' => '2022-02-11 20:42:17',
            'id_role' => 2
        ]);

    }
}
