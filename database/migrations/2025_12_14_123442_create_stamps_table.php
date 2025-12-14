<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stamps', function (Blueprint $table) {
            $table->id();

            // 将来：スタンプセット商品と紐付け
            $table->unsignedBigInteger('item_id')->nullable();

            $table->string('name');
            $table->string('image_path');
            $table->integer('sort_order')->default(0);

            $table->timestamps();

            $table->foreign('item_id')
                  ->references('id')
                  ->on('items')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stamps');
    }
};
