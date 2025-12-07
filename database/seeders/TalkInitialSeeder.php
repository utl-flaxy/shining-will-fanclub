<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Talk;
use App\Models\TalkMember;
use App\Models\Talent;

class TalkInitialSeeder extends Seeder
{
    public function run(): void
    {
        // ⭐ まずユーザー作成
        $user = User::firstOrCreate(
            ['email' => 'test@fan.com'],
            [
                'name' => 'テストユーザー',
                'password' => bcrypt('password'),
            ]
        );

        // ⭐ タレント作成
        $talent = Talent::firstOrCreate(
            ['name' => 'Bety'],
            ['color' => '#6b5bff']
        );

        // ⭐ トーク部屋作成
        $talk = Talk::firstOrCreate(
            ['name' => 'Bety グループ'],
            [
                'color' => '#6b5bff',
                'type' => 'group',
                'status' => 'active',
            ]
        );

        // ⭐ トークメンバー登録
        TalkMember::firstOrCreate([
            'talk_id' => $talk->id,
            'user_id' => $user->id,
            'talent_id' => $talent->id,
        ]);
    }
}
