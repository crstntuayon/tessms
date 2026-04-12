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
        Schema::create('report_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saved_report_id')->constrained('saved_reports')->cascadeOnDelete();
            $table->string('frequency'); // daily, weekly, monthly, quarterly
            $table->json('schedule_config'); // day of week, day of month, etc.
            $table->json('recipients'); // email addresses or user IDs
            $table->string('format')->default('pdf'); // pdf, excel, csv
            $table->string('delivery_method')->default('email'); // email, download, webhook
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamp('next_send_at')->nullable();
            $table->integer('send_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['frequency', 'is_active']);
            $table->index('next_send_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_schedules');
    }
};
