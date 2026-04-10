<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_school_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_year_id')->constrained()->onDelete('cascade');
            
            // Month and year
            $table->tinyInteger('month')->unsigned(); // 1-12
            $table->year('year');
            
            // Configurable school days
            $table->integer('total_school_days')->default(0);
            $table->json('school_dates')->nullable(); // Array of actual school dates ["2026-06-01", "2026-06-02", ...]
            
            // Non-school days tracking with reasons
            $table->json('non_school_days')->nullable(); // [{"date": "2026-06-12", "reason": "Independence Day"}, ...]
            
            // Notes from teacher
            $table->text('teacher_notes')->nullable();
            
            // Who configured this
            $table->foreignId('configured_by')->nullable()->constrained('users');
            $table->timestamp('configured_at')->nullable();
            
            // Is this finalized for the month
            $table->boolean('is_finalized')->default(false);
            
            $table->timestamps();
            
            // Unique constraint - one record per section per month per year
            $table->unique(['section_id', 'school_year_id', 'month', 'year'], 'unique_section_month_year');
            
            // Indexes
            $table->index(['school_year_id', 'month', 'year']);
            $table->index(['section_id', 'is_finalized']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_school_days');
    }
};
