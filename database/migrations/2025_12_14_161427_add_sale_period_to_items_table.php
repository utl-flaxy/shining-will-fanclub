<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {

            // 掲載開始（一覧に表示されるタイミング）
            $table->timestamp('publish_start_at')
                ->nullable()
                ->after('is_active');

            // 販売開始（購入できるタイミング）
            $table->timestamp('sale_start_at')
                ->nullable()
                ->after('publish_start_at');

            // 販売終了
            $table->timestamp('sale_end_at')
                ->nullable()
                ->after('sale_start_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn([
                'publish_start_at',
                'sale_start_at',
                'sale_end_at',
            ]);
        });
    }
};
