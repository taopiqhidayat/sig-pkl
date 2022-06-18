<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admmin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'n_wa' => '083456876123',
            'password' => Hash::make('Admin123'),
            'is_admin' => 1,
        ]);
    }
}
