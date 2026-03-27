<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();

            // Core grading identifiers
            $table->integer('quarter'); // 1–4
            $table->string('component_type'); 
            // written_work | performance_task | quarterly_exam | final_grade

            // Component scores
            $table->json('scores')->nullable(); // for WW/PT
            $table->integer('total_score')->nullable();
            $table->decimal('percentage_score', 5, 2)->nullable();

            // Weighted scores (for final grade)
            $table->decimal('ww_weighted', 5, 2)->nullable();
            $table->decimal('pt_weighted', 5, 2)->nullable();
            $table->decimal('qe_weighted', 5, 2)->nullable();

            // Final grade
            $table->decimal('initial_grade', 5, 2)->nullable();
            $table->integer('final_grade')->nullable();
            $table->string('remarks')->nullable();

            $table->timestamps();

            // Prevent duplicate records
            $table->unique([
                'section_id',
                'student_id',
                'subject_id',
                'quarter',
                'component_type'
            ], 'unique_grade_record');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};