<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Suzuya',
            'email' => 'suzuya4w@gmail.com',
            'password' => bcrypt('secret'),
            'role' => 'manager'
        ]);

        User::factory()->create([
            'name' => 'Dennyson',
            'email' => 'dennyson@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);
    }
}