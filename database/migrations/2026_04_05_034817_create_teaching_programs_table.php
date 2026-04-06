<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teaching_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_year_id')->constrained()->onDelete('cascade');
            $table->enum('day', ['M', 'T', 'W', 'TH', 'F']);
            $table->time('time_from');
            $table->time('time_to');
            $table->string('subject')->nullable();
            $table->text('activity')->nullable();
            $table->integer('minutes')->default(0);
            $table->timestamps();
            
           $table->unique(
    ['teacher_id', 'section_id', 'school_year_id', 'day', 'time_from'],
    'tp_unique_schedule'
);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teaching_programs');
    }
};