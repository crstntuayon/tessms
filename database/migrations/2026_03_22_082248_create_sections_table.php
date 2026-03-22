<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., "Grade 1 - A"
            $table->string('level')->nullable(); // e.g., "Grade 1", "Grade 2"
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null'); // optional class adviser
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};