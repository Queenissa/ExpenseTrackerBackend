<?php

namespace Database\Seeders;

use Database\Factories\Factory;
use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     \App\Models\User::factory(20)->create();
    }
}
