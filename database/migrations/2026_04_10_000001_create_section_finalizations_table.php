<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('section_finalizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_year_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            
            // Finalization status for each component
            $table->boolean('grades_finalized')->default(false);
            $table->timestamp('grades_finalized_at')->nullable();
            
            $table->boolean('attendance_finalized')->default(false);
            $table->timestamp('attendance_finalized_at')->nullable();
            
            $table->boolean('core_values_finalized')->default(false);
            $table->timestamp('core_values_finalized_at')->nullable();
            
            // Overall finalization
            $table->boolean('is_fully_finalized')->default(false);
            $table->timestamp('finalized_at')->nullable();
            $table->foreignId('finalized_by')->nullable()->constrained('users');
            
            // Lock status (admin can unlock)
            $table->boolean('is_locked')->default(false);
            $table->timestamp('locked_at')->nullable();
            
            // Unlock history
            $table->timestamp('unlocked_at')->nullable();
            $table->foreignId('unlocked_by')->nullable()->constrained('users');
            $table->text('unlock_reason')->nullable();
            
            // Auto-finalize deadline
            $table->timestamp('deadline_at')->nullable();
            $table->boolean('auto_finalized')->default(false);
            
            $table->timestamps();
            
            // Unique constraint - one record per section per school year
            $table->unique(['section_id', 'school_year_id'], 'unique_section_school_year');
            
            // Indexes
            $table->index(['school_year_id', 'is_fully_finalized']);
            $table->index(['teacher_id', 'is_fully_finalized']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('section_finalizations');
    }
};
