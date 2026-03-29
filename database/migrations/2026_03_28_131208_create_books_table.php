<?php
// database/migrations/xxxx_create_books_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Books/Materials Master List
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subject');
            $table->string('grade_level');
            $table->string('isbn')->nullable();
            $table->string('publisher')->nullable();
            $table->integer('year_published')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('total_copies')->default(0);
            $table->integer('available_copies')->default(0);
            $table->enum('type', ['textbook', 'workbook', 'reference', 'module', 'other'])->default('textbook');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Book Issuance Records (SF3 Core)
        Schema::create('book_issuances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_year_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->nullable()->constrained()->onDelete('set null');
            
            // Issuance Info
            $table->date('date_issued');
            $table->string('condition_issued')->default('Good'); // Good, Fair, Poor
            $table->string('issued_by');
            
            // Return Info
            $table->date('date_returned')->nullable();
            $table->string('condition_returned')->nullable(); // Good, Fair, Poor, Damaged, Lost
            $table->string('returned_to')->nullable();
            $table->decimal('fine_amount', 10, 2)->default(0);
            $table->text('remarks')->nullable();
            
            // Status
            $table->enum('status', ['issued', 'returned', 'lost', 'damaged'])->default('issued');
            
            $table->timestamps();
            
            // Prevent duplicate active issuance for same book and student in same school year
            $table->unique(['student_id', 'book_id', 'school_year_id'], 'unique_active_issuance');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_issuances');
        Schema::dropIfExists('books');
    }
};