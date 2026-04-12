<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grade_weights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_year_id')->constrained()->onDelete('cascade');
            $table->integer('quarter');
            $table->decimal('ww_weight', 5, 2)->default(40.00);
            $table->decimal('pt_weight', 5, 2)->default(40.00);
            $table->decimal('qe_weight', 5, 2)->default(20.00);
            $table->timestamps();
            
            // Unique constraint to prevent duplicates
            $table->unique(['section_id', 'subject_id', 'school_year_id', 'quarter'], 'unique_grade_weights');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_weights');
    }
};
