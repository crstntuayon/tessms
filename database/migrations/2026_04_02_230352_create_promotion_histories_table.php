<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotion_histories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('from_school_year_id');
            $table->unsignedBigInteger('to_school_year_id');
            $table->unsignedBigInteger('from_grade_level_id');
            $table->unsignedBigInteger('to_grade_level_id');

            $table->timestamps();

            // Foreign keys
            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');

            $table->foreign('from_school_year_id')
                ->references('id')
                ->on('school_years')
                ->onDelete('cascade');

            $table->foreign('to_school_year_id')
                ->references('id')
                ->on('school_years')
                ->onDelete('cascade');

            $table->foreign('from_grade_level_id')
                ->references('id')
                ->on('grade_levels')
                ->onDelete('cascade');

            $table->foreign('to_grade_level_id')
                ->references('id')
                ->on('grade_levels')
                ->onDelete('cascade');

            // Optional: unique promotion per student per year
            $table->unique(['student_id', 'from_school_year_id', 'to_school_year_id'], 'promotion_unique_per_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_histories');
    }
};