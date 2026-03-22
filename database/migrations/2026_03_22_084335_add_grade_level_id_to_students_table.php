<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('grade_level_id')->nullable()->after('id'); // add after id or wherever
            $table->foreign('grade_level_id')->references('id')->on('grade_levels')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['grade_level_id']);
            $table->dropColumn('grade_level_id');
        });
    }
};