<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class SingleUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'is_active_member' => true,
        ]);

        $user->assignRole('user');
    }
}
