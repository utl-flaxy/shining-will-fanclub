<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Membership;
use App\Models\Post;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\Item;

class DemoFanclubSeeder extends Seeder
{
    public function run(): void
    {
        echo "🌱 Seeding fanclub demo data...\n";

        // Membership
        $free = Membership::create(['name' => '無料会員', 'level' => 1, 'monthly_fee' => 0]);
        $premium = Membership::create(['name' => 'プレミアム会員', 'level' => 2, 'monthly_fee' => 500]);

        // Users
        $admin = User::factory()->create([
            'name' => 'Official Admin',
            'email' => 'admin@bety.jp',
            'membership_level' => 2,
        ]);

        $idol = User::factory()->create([
            'name' => 'Bety Official',
            'email' => 'bety@bety.jp',
            'membership_level' => 2,
        ]);

        $user = User::factory()->create([
            'name' => 'Sample Fan',
            'email' => 'fan@bety.jp',
            'membership_level' => 2,
        ]);

        // Posts
        Post::create([
            'user_id' => $idol->id,
            'title' => '限定メッセージ💌',
            'body' => 'いつも応援ありがとう！',
            'is_premium' => true,
        ]);

        // Chat
        $room = ChatRoom::create(['name' => 'Bety Group Chat', 'type' => 'public']);
        ChatMessage::create([
            'room_id' => $room->id,
            'user_id' => $idol->id,
            'message' => 'こんにちは！Betyです💖',
        ]);
        ChatMessage::create([
            'room_id' => $room->id,
            'user_id' => $user->id,
            'message' => 'Betyちゃんお疲れ様〜！',
        ]);

        // Items
        Item::create(['name' => 'ハートスタンプ', 'type' => 'sticker', 'price' => 100]);
        Item::create(['name' => 'ピンク背景', 'type' => 'theme', 'price' => 200]);

        echo "✅ Demo data inserted.\n";
    }
}
