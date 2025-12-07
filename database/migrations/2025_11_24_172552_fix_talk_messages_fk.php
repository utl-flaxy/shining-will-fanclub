<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('talk_messages', function (Blueprint $table) {
            // 古い外部キー削除
            $table->dropForeign('talk_messages_room_id_foreign');

            // 必要ならカラム名変更（既に talk_id ならスキップ）
            // $table->renameColumn('room_id', 'talk_id');

            // 正しい外部キーを再設定
            $table->foreign('talk_id')
                ->references('id')->on('talks')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('talk_messages', function (Blueprint $table) {
            $table->dropForeign(['talk_id']);
        });
    }
};
