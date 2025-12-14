<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('talk_messages', function (Blueprint $table) {
            // text / image / stamp
            $table->string('type')->default('text')->after('user_id');

            // スタンプ送信時のみ使用
            $table->unsignedBigInteger('stamp_id')->nullable()->after('type');

            $table->foreign('stamp_id')
                  ->references('id')
                  ->on('stamps')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('talk_messages', function (Blueprint $table) {
            $table->dropForeign(['stamp_id']);
            $table->dropColumn(['type', 'stamp_id']);
        });
    }
};
