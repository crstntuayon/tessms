<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_inventory_id')->nullable()->constrained()->nullOnDelete();

            // Book details
            $table->string('title');
            $table->string('subject_area')->nullable();
            $table->string('book_code')->nullable();
            $table->string('reference_code')->nullable();

            // Dates
            $table->date('date_issued')->nullable();
            $table->date('date_returned')->nullable();

            // Status fields
            $table->enum('status', ['issued', 'returned', 'lost', 'damaged'])->default('issued');

            $table->enum('condition', ['good', 'damaged', 'lost'])->nullable();

            $table->text('damage_details')->nullable();

            $table->enum('loss_code', ['FM', 'TDO', 'NEG'])->nullable();

            $table->enum('action_taken', ['LLTR', 'TLTR', 'PTL', 'NONE'])->default('NONE');

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
