<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'Rahmad Arif',
            'email' => 'arif@mail.com',
            'password' => Hash::make("arif1234"),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
