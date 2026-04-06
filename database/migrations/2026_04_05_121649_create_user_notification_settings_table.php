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
        Schema::create('user_notification_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Email notification preferences
            $table->boolean('email_new_message')->default(true);
            $table->boolean('email_announcement')->default(true);
            $table->boolean('email_grade_posted')->default(true);
            $table->boolean('email_attendance_alert')->default(true);
            $table->boolean('email_assignment_due')->default(true);
            
            // SMS notification preferences
            $table->boolean('sms_new_message')->default(false);
            $table->boolean('sms_announcement')->default(false);
            $table->boolean('sms_grade_posted')->default(false);
            $table->boolean('sms_attendance_alert')->default(true); // Urgent
            $table->boolean('sms_assignment_due')->default(false);
            
            // Contact info
            $table->string('phone_number')->nullable();
            $table->boolean('phone_verified')->default(false);
            
            $table->timestamps();
            
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notification_settings');
    }
};
