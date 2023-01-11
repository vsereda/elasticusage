<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create(['name' => 'Lexie Lesch']);
        User::factory(1)->create(['name' => 'Leixe Brown']);
        User::factory(2)->create();
    }
}
