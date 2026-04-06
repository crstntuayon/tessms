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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // 'message', 'announcement', 'grade', 'attendance', etc.
            $table->string('title');
            $table->text('body');
            $table->json('data')->nullable(); // Additional data like message_id, url, etc.
            $table->timestamp('read_at')->nullable();
            $table->timestamp('sent_via_email_at')->nullable();
            $table->timestamp('sent_via_sms_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'read_at']);
            $table->index(['type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
