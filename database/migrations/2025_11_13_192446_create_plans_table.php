<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            $table->string('name');                // プラン名（例：Bety 月額会員）
            $table->text('description')->nullable(); // 説明文
            $table->integer('price');             // 税込み or 税抜き（Stripeと合わせる）
            $table->string('interval')->default('month'); // month / year
            $table->string('stripe_price_id');     // Stripeダッシュボードで発行される price_xxx

            $table->boolean('is_active')->default(true); // 公開 / 非公開
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
