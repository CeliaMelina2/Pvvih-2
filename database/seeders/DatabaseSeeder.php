<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Centre;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'pviih@contant.com',
            'password' => bcrypt('pviih@contant.com'),
            'role' => 'admin',
        ]);
        Centre::factory(1)->create();
    }

}
