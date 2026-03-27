<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('subjects', function (Blueprint $table) {
        $table->unsignedBigInteger('grade_level_id')->after('id')->nullable();

        // Optional: add foreign key if you have a grade_levels table
        $table->foreign('grade_level_id')->references('id')->on('grade_levels')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('subjects', function (Blueprint $table) {
        $table->dropForeign(['grade_level_id']);
        $table->dropColumn('grade_level_id');
    });
}
};
