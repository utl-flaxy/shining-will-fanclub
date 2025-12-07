<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('talk_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color')->nullable();
            $table->boolean('is_pinned')->default(false); // ← これが必須
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('talk_rooms');
    }
};
