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
        Schema::table('notifications', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('notifications', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('notifications', 'type')) {
                $table->string('type');
            }
            if (!Schema::hasColumn('notifications', 'title')) {
                $table->string('title');
            }
            if (!Schema::hasColumn('notifications', 'body')) {
                $table->text('body');
            }
            if (!Schema::hasColumn('notifications', 'data')) {
                $table->json('data')->nullable();
            }
            if (!Schema::hasColumn('notifications', 'read_at')) {
                $table->timestamp('read_at')->nullable();
            }
            if (!Schema::hasColumn('notifications', 'sent_via_email_at')) {
                $table->timestamp('sent_via_email_at')->nullable();
            }
            if (!Schema::hasColumn('notifications', 'sent_via_sms_at')) {
                $table->timestamp('sent_via_sms_at')->nullable();
            }
        });

        // Add indexes
        Schema::table('notifications', function (Blueprint $table) {
            if (!Schema::hasIndex('notifications', 'notifications_user_id_read_at_index')) {
                $table->index(['user_id', 'read_at']);
            }
            if (!Schema::hasIndex('notifications', 'notifications_type_created_at_index')) {
                $table->index(['type', 'created_at']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Don't remove columns in down() to prevent data loss
        });
    }
};
