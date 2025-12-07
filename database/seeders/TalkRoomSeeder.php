<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TalkRoom;

class TalkRoomSeeder extends Seeder
{
    public function run(): void
    {
        TalkRoom::insert([
            [
                'id' => 1,
                'name' => 'Bety 公式お知らせ',
                'color' => 'linear-gradient(135deg, #ffb347, #ff6b6b)',
                'is_pinned' => true
            ],
            [
                'id' => 2,
                'name' => 'うり',
                'color' => 'linear-gradient(135deg, #5af58b, #39c66b)',
            ],
            [
                'id' => 3,
                'name' => '小坂さな',
                'color' => 'linear-gradient(135deg, #ffcf7b, #ffb347)',
            ],
            [
                'id' => 4,
                'name' => '土井まな',
                'color' => 'linear-gradient(135deg, #f7d774, #d6a824)',
            ],
            [
                'id' => 5,
                'name' => '結貴漓南',
                'color' => 'linear-gradient(135deg, #6bb7ff, #4169e1)',
            ],
            [
                'id' => 6,
                'name' => '清水梨央奈',
                'color' => 'linear-gradient(135deg, #f5f5f7, #d1d1e0)',
            ],
        ]);
    }
}
