<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->foreignId('grade_level_id')->nullable()->constrained('grade_levels')->nullOnDelete();
            $table->foreignId('school_year_id')->nullable()->constrained('school_years')->nullOnDelete();
            $table->string('room_number', 50)->nullable();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete(); // Adviser
            $table->integer('capacity')->nullable();
            $table->timestamps();
        });

        // Pivot table for section ↔ teacher many-to-many
        Schema::create('teacher_section', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('section_id')->constrained('sections')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['teacher_id', 'section_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_section');
        Schema::dropIfExists('sections');
    }
};