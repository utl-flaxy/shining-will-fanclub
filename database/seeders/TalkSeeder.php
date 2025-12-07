<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TalkRoom;
use App\Models\TalkMessage;
use Illuminate\Support\Facades\Hash;

class TalkSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. テストユーザー & タレントユーザー取得
        |--------------------------------------------------------------------------
        | ※ DatabaseSeeder で作成済みのユーザーを取得する
        */
        $user = User::where('email', 'test@example.com')->first();
        $talent = User::where('email', 'talent@example.com')->first();

        if (!$user || !$talent) {
            dump("❌ test@example.com または talent@example.com が見つかりません。Seederの順序を確認してください。");
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | 2. トークルーム作成（あなたの UI と完全対応）
        |--------------------------------------------------------------------------
        */
        $roomsData = [
            ['name' => 'グループチャット', 'color' => '#000000', 'is_pinned' => true],
            ['name' => 'うり', 'color' => '#00c853'],
            ['name' => '小坂さな', 'color' => '#ff9100'],
            ['name' => '土井まな', 'color' => '#ffd600'],
            ['name' => '結貴漓南', 'color' => '#2979ff'],
            ['name' => '清水梨央奈', 'color' => '#ffffff'],
        ];

        $rooms = [];

        foreach ($roomsData as $data) {
            $rooms[] = TalkRoom::create($data);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. 各ルームにメッセージ10件ずつ生成
        |--------------------------------------------------------------------------
        */
        foreach ($rooms as $room) {

            for ($i = 1; $i <= 10; $i++) {

                // タレントからのメッセージ
                TalkMessage::create([
                    'room_id' => $room->id,
                    'user_id' => $talent->id,
                    'message' => "{$room->name} よりタレントメッセージ {$i}",
                ]);

                // ユーザーからの返信
                TalkMessage::create([
                    'room_id' => $room->id,
                    'user_id' => $user->id,
                    'message' => "返信 {$i}",
                ]);
            }
        }
    }
}
