<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the enum column to include 'continuing'
        DB::statement("ALTER TABLE enrollment_applications MODIFY COLUMN application_type ENUM('new_student', 'transfer', 'returning', 'continuing') DEFAULT 'new_student'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE enrollment_applications MODIFY COLUMN application_type ENUM('new_student', 'transfer', 'returning') DEFAULT 'new_student'");
    }
};
