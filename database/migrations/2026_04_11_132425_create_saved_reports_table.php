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
        Schema::create('saved_reports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('template_id')->constrained('report_templates')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->json('parameters'); // saved filter parameters
            $table->json('column_visibility')->nullable(); // which columns are visible
            $table->string('format')->default('html'); // html, pdf, excel, csv
            $table->string('schedule_frequency')->nullable(); // daily, weekly, monthly
            $table->json('schedule_config')->nullable(); // schedule details
            $table->timestamp('last_run_at')->nullable();
            $table->timestamp('next_run_at')->nullable();
            $table->boolean('is_favorite')->default(false);
            $table->boolean('is_scheduled')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'is_favorite']);
            $table->index(['template_id', 'user_id']);
            $table->index('is_scheduled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_reports');
    }
};
