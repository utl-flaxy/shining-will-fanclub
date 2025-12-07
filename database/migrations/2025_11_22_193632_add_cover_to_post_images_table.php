<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('post_images', function (Blueprint $table) {
            $table->boolean('cover')->default(false)->after('sort_order');
        });
    }

    public function down()
    {
        Schema::table('post_images', function (Blueprint $table) {
            $table->dropColumn('cover');
        });
    }
};
