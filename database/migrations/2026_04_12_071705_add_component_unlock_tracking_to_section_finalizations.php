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
        Schema::table('section_finalizations', function (Blueprint $table) {
            // Component-specific unlock tracking
            $table->timestamp('grades_unlocked_at')->nullable()->after('unlocked_by');
            $table->foreignId('grades_unlocked_by')->nullable()->constrained('users')->nullOnDelete()->after('grades_unlocked_at');
            $table->text('grades_unlock_reason')->nullable()->after('grades_unlocked_by');
            
            $table->timestamp('attendance_unlocked_at')->nullable()->after('grades_unlock_reason');
            $table->foreignId('attendance_unlocked_by')->nullable()->constrained('users')->nullOnDelete()->after('attendance_unlocked_at');
            $table->text('attendance_unlock_reason')->nullable()->after('attendance_unlocked_by');
            
            $table->timestamp('core_values_unlocked_at')->nullable()->after('attendance_unlock_reason');
            $table->foreignId('core_values_unlocked_by')->nullable()->constrained('users')->nullOnDelete()->after('core_values_unlocked_at');
            $table->text('core_values_unlock_reason')->nullable()->after('core_values_unlocked_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('section_finalizations', function (Blueprint $table) {
            $table->dropForeign(['grades_unlocked_by']);
            $table->dropForeign(['attendance_unlocked_by']);
            $table->dropForeign(['core_values_unlocked_by']);
            
            $table->dropColumn([
                'grades_unlocked_at',
                'grades_unlocked_by',
                'grades_unlock_reason',
                'attendance_unlocked_at',
                'attendance_unlocked_by',
                'attendance_unlock_reason',
                'core_values_unlocked_at',
                'core_values_unlocked_by',
                'core_values_unlock_reason',
            ]);
        });
    }
};
