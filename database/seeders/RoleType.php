<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_type')->insert([
            'id' => 1,
            'name' =>'Admin',
            'name_screen'=>'Administrador'
        ]);
        DB::table('role_type')->insert([
            'id' => 2,
            'name' =>'Normal User',
            'name_screen'=>'Usuario Normal'
        ]);
    }
}
