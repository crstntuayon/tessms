<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kindergarten_domains', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('student_id');
            $table->string('domain');              // Developmental Domain (e.g., Kahimsog, Pinulongan)
            $table->string('indicator_key');       // Indicator key (e.g., GM1, FM1)
            $table->text('indicator');             // Full indicator text in Cebuano
            $table->string('rating', 10);          // B, D, C (Beginning, Developing, Consistent)
            $table->text('remarks')->nullable();   // Optional remarks
            $table->unsignedTinyInteger('quarter'); // 1-4
            $table->unsignedBigInteger('school_year_id');
            $table->unsignedBigInteger('recorded_by');

            $table->timestamps();

            // Unique constraint to prevent duplicates
            $table->unique([
                'student_id',
                'domain',
                'indicator_key',
                'quarter',
                'school_year_id'
            ], 'kindergarten_domains_unique');

            // Foreign keys
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kindergarten_domains');
    }
};
