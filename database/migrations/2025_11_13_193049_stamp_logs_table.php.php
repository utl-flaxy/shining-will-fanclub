<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stamp_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stamp_card_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('stamps_added');       // 付与 or マイナスも想定ならマイナスOK
            $table->string('reason')->nullable();  // 例：イベント入場、通販購入 etc
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stamp_logs');
    }
};
