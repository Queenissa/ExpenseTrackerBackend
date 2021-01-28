<?php

namespace Database\Seeders;

use Database\Factories\Factory;
use Illuminate\Database\Seeder;
use DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Rhea May',
            'last_name' => 'Ardiente',
            'email' => 'rhea-may.ardiente@gmail.com',
            'is_admin' => '1',
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'first_name' => 'Leordan',
            'last_name' => 'Carmona',
            'email' => 'leordan.carmona@gmail.com',
            'is_admin' => '0',
            'password' => bcrypt('password'),
        ]);
    }
}
