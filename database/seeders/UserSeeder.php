<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');

        $talent = User::create([
            'name' => 'Test Talent',
            'email' => 'talent@test.com',
            'password' => bcrypt('password'),
        ]);
        $talent->assignRole('talent');
    }
}
