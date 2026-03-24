<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('grade_levels', function (Blueprint $table) {
            $table->integer('order')->after('name')->default(0);
            $table->boolean('is_final')->after('order')->default(false);
        });
    }

    public function down()
    {
        Schema::table('grade_levels', function (Blueprint $table) {
            $table->dropColumn(['order', 'is_final']);
        });
    }
};