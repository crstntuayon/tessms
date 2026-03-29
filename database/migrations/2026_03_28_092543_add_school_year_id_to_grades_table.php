<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            // Add column AFTER student_id (optional but clean)
            $table->foreignId('school_year_id')
                ->nullable()
                ->after('student_id')
                ->constrained('school_years')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropForeign(['school_year_id']);
            $table->dropColumn('school_year_id');
        });
    }
};
