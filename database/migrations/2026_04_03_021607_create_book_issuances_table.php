<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books_issuances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_year_id')->constrained()->onDelete('cascade');
            $table->string('book_title');
            $table->string('book_number')->nullable();
            $table->date('date_issued');
            $table->date('date_returned')->nullable();
            $table->enum('condition_issued', ['new', 'good', 'fair', 'poor']);
            $table->enum('condition_returned', ['new', 'good', 'fair', 'poor', 'damaged', 'lost'])->nullable();
            $table->foreignId('issued_by')->constrained('users');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books_issuances');
    }
};