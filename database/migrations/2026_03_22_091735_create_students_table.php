<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('lrn', 50)->nullable()->unique();
            $table->date('birthdate')->nullable();
            $table->string('birth_place', 150)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('nationality', 100)->nullable();
            $table->string('religion', 100)->nullable();

            $table->string('father_name', 150)->nullable();
            $table->string('father_occupation', 100)->nullable();
            $table->string('mother_name', 150)->nullable();
            $table->string('mother_occupation', 100)->nullable();
            $table->string('guardian_name', 150)->nullable();
            $table->string('guardian_relationship', 50)->nullable();
            $table->string('guardian_contact', 50)->nullable();

            $table->string('street_address', 255)->nullable();
            $table->string('barangay', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('zip_code', 20)->nullable();

            $table->string('status', 50)->default('active');

            $table->foreignId('grade_level_id')->nullable()->constrained('grade_levels')->nullOnDelete();
            $table->foreignId('section_id')->nullable()->constrained('sections')->nullOnDelete();

            $table->string('photo', 255)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};