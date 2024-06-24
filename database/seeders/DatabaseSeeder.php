<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use App\Models\Property;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        AdminUser::factory(1)->create([
            "name" => 'Admin',
            "login" => 'Admin',
            "password" => bcrypt("121212")

        ]);

        Property::factory(1)->create([
            "name" => 'Размер',
            "type" => 'string',
            "categories" => '1'
        ]);

        Property::factory(1)->create([
            "name" => 'Вес',
            "type" => 'string',
            "categories" => '1,2'
        ]);

    }
}
