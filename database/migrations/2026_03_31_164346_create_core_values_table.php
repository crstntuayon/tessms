<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('core_values', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('student_id'); // reference student
            $table->string('core_value');             // Maka-Diyos, Maka-tao, etc.
            $table->string('statement_key');          // statement1, 1.1, etc.
            $table->text('behavior_statement');       // full statement text
            $table->string('rating');                 // AO, SO, RO, NO
            $table->text('remarks')->nullable();      // optional remarks
            $table->unsignedTinyInteger('quarter');   // 1-4
            $table->unsignedBigInteger('school_year_id'); // reference active school year
            $table->unsignedBigInteger('recorded_by');    // user id who recorded

            $table->timestamps();

            // ✅ Unique constraint to prevent duplicate statements
            $table->unique([
                'student_id',
                'core_value',
                'statement_key',
                'quarter',
                'school_year_id'
            ], 'core_values_unique_full');

            // ✅ Optional: Foreign keys if you have students & school_years tables
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('core_values');
    }
};