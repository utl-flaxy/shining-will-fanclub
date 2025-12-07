<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        echo "📌 Creating admin user...\n";

        // 既存削除（不要ならコメントアウトOK）
        User::where('email', 'admin@fanclub.jp')->delete();

        // 管理者アカウント作成
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@fanclub.jp',
            'password' => bcrypt('password'),
        ]);

        // admin ロール作成（なければ作成）
        $role = Role::firstOrCreate(['name' => 'admin']);

        // ロールを紐づけ
        $admin->roles()->sync([$role->id]);

        echo "🎉 Admin created: admin@fanclub.jp / password\n";
    }
}
