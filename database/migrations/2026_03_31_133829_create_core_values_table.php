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
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->enum('core_value', ['Maka-Diyos', 'Maka-tao', 'Makakalikasan', 'Makabansa']);
            $table->text('behavior_statement');
            $table->tinyInteger('quarter')->unsigned();
            $table->enum('rating', ['AO', 'SO', 'RO', 'NO']);
            $table->foreignId('school_year_id')->nullable()->constrained();
            $table->foreignId('recorded_by')->nullable()->constrained('users');
            $table->text('remarks')->nullable();
            $table->timestamps();

            // Prevent duplicate entries per student per core value per quarter per school year
            $table->unique(
                ['student_id', 'core_value', 'quarter', 'school_year_id'],
                'unique_core_value_per_quarter'
            );

            // Indexes for performance
            $table->index(['student_id', 'quarter']);
            $table->index(['school_year_id', 'quarter']);
            $table->index('core_value');
            $table->index('rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('core_values');
    }
};