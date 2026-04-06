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
    Schema::create('sf3_records', function (Blueprint $table) {
        $table->id();

        $table->foreignId('student_id')->constrained()->cascadeOnDelete();
        $table->foreignId('book_id')->constrained()->cascadeOnDelete();
        $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();

        // 🔥 IMPORTANT for SF3 reports
        $table->foreignId('school_year_id')->constrained()->cascadeOnDelete();
        $table->foreignId('section_id')->nullable()->constrained()->nullOnDelete();

        $table->date('date_issued');
        $table->date('date_returned')->nullable();

        $table->enum('status', ['issued', 'returned'])->default('issued');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sf3_records');
    }
};
