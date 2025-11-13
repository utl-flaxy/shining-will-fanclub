<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');                       // プラン名（例：通常会員）
            $table->text('description')->nullable();      // 説明文
            $table->unsignedInteger('price');             // 料金（円）
            $table->string('interval')->default('month'); // 課金間隔（とりあえず month 固定想定）
            $table->string('stripe_price_id');            // Stripe の price ID
            $table->boolean('is_active')->default(true);  // 有効フラグ
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};