<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // アイテム名（スタンプ名など）
            $table->text('description')->nullable();
            $table->string('type');                  // 'stamp', 'talk_background' など
            $table->unsignedInteger('price');        // 金額（円）
            $table->boolean('is_active')->default(true);
            $table->string('image_path')->nullable();// プレビュー画像
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
