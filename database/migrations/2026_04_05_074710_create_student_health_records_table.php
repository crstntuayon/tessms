<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_health_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_year_id')->constrained()->onDelete('cascade');
            $table->enum('period', ['bosy', 'eosy'])->comment('Beginning/End of School Year');
            $table->decimal('weight', 5, 2)->nullable()->comment('in kg');
            $table->decimal('height', 4, 2)->nullable()->comment('in meters');
            $table->decimal('bmi', 5, 2)->nullable()->comment('kg/m²');
            $table->string('nutritional_status')->nullable()->comment('Severely Wasted, Wasted, Normal, Overweight, Obese');
            $table->string('height_for_age')->nullable()->comment('Severely Stunted, Stunted, Normal, Tall');
            $table->text('remarks')->nullable();
            $table->date('date_of_assessment')->nullable();
            $table->foreignId('assessed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Unique constraint - one record per student per period per school year
            $table->unique(['student_id', 'section_id', 'school_year_id', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_health_records');
    }
};