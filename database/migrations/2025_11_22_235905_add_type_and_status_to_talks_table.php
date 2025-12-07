<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('talks', function (Blueprint $table) {
            $table->string('type')->default('group')->after('name');    // 個人 or グループ
            $table->string('status')->default('active')->after('type'); // active / archived 等
        });
    }

    public function down()
    {
        Schema::table('talks', function (Blueprint $table) {
            $table->dropColumn(['type', 'status']);
        });
    }
};
