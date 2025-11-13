<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id'); // 投稿者（管理者）
            $table->string('title');              // タイトル
            $table->text('body')->nullable();     // 本文（リッチテキスト）
            $table->string('image_path')->nullable(); // 画像
            $table->string('video_url')->nullable();  // YouTube / TikTok など

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
