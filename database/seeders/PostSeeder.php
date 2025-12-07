<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin  = User::where('email', 'admin@example.com')->first();
        $talent = User::where('email', 'talent@example.com')->first();
        $user   = User::where('email', 'test@example.com')->first();

        Post::create([
            'user_id' => $admin->id,
            'title' => 'テスト投稿①',
            'body' => 'これは管理者の投稿本文です。',
            'status' => 'public',
        ]);

        Post::create([
            'user_id' => $talent->id,
            'title' => 'テスト投稿②',
            'body' => 'タレント投稿の本文。',
            'status' => 'public',
        ]);

        Post::create([
            'user_id' => $user->id,
            'title' => 'テスト投稿③（下書き）',
            'body' => '一般ユーザーの下書き本文です。',
            'status' => 'draft',
        ]);
    }
}
