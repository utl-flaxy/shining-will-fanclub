<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Talent;

class TalentSeeder extends Seeder
{
    public function run(): void
    {
        $talentData = [
            ['name' => 'うり', 'color' => 'green', 'email' => 'uri@fanclub.jp'],
            ['name' => '小坂さな', 'color' => 'orange', 'email' => 'sana@fanclub.jp'],
            ['name' => '土井まな', 'color' => 'yellow', 'email' => 'mana@fanclub.jp'],
            ['name' => '清水梨央奈', 'color' => 'white', 'email' => 'riona@fanclub.jp'],
            ['name' => '結貴漓南', 'color' => 'blue', 'email' => 'rina@fanclub.jp'],
        ];

        foreach ($talentData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('password'),
                'is_active_member' => true,
            ]);
            $user->assignRole('talent');

            Talent::create([
                'user_id' => $user->id,
                'name'    => $data['name'],
                'color'   => $data['color'],
            ]);
        }
    }
}
