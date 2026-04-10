<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_year_closures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_year_id')->constrained()->onDelete('cascade');
            
            // Closure status
            $table->enum('status', ['pending', 'ready_to_close', 'closing', 'closed'])->default('pending');
            
            // Finalization tracking
            $table->integer('total_sections')->default(0);
            $table->integer('finalized_sections')->default(0);
            $table->boolean('all_sections_finalized')->default(false);
            
            // Closure timestamps
            $table->timestamp('closure_started_at')->nullable();
            $table->timestamp('closure_completed_at')->nullable();
            $table->foreignId('closed_by')->nullable()->constrained('users');
            
            // Settings
            $table->timestamp('finalization_deadline')->nullable();
            $table->boolean('auto_close_enabled')->default(false);
            $table->timestamp('auto_close_at')->nullable();
            
            // Notes
            $table->text('admin_notes')->nullable();
            $table->text('closure_summary')->nullable();
            
            $table->timestamps();
            
            // Unique constraint - one closure record per school year
            $table->unique(['school_year_id'], 'unique_school_year_closure');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_year_closures');
    }
};
