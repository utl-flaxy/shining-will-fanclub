<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchased_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('item_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamp('purchased_at')->useCurrent();

            $table->timestamps();

            // 同一ユーザーが同一アイテムを複数回買える設計
            // （制限したい場合は unique を追加）
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchased_items');
    }
};
