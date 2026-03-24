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
    Schema::table('enrollments', function (Blueprint $table) {
        $table->unsignedBigInteger('school_year_id')->after('id');
        $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('enrollments', function (Blueprint $table) {
        $table->dropForeign(['school_year_id']);
        $table->dropColumn('school_year_id');
    });
}
};
