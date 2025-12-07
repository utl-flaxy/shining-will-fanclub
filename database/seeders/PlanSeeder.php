<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'name' => 'Bety 月額会員',
            'description' => '限定投稿・限定チャットが使える月額プラン',
            'price' => 500,
            'interval' => 'month',
            'stripe_price_id' => 'price_xxxxxxx', // ← Stripe dashboard で設定後に入力
            'is_active' => true,
        ]);
    }
}
