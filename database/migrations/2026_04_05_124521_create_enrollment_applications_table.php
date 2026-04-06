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
        Schema::create('enrollment_applications', function (Blueprint $table) {
            $table->id();
            
            // Application Status
            $table->enum('status', ['draft', 'pending', 'under_review', 'approved', 'rejected', 'waitlisted'])
                  ->default('pending');
            $table->enum('application_type', ['new_student', 'transfer', 'returning'])->default('new_student');
            $table->string('application_number')->unique(); // Auto-generated like ENR-2024-0001
            
            // School Year & Grade Level
            $table->foreignId('school_year_id')->constrained()->onDelete('cascade');
            $table->foreignId('grade_level_id')->constrained()->onDelete('cascade');
            
            // Student Information
            $table->string('student_first_name');
            $table->string('student_middle_name')->nullable();
            $table->string('student_last_name');
            $table->string('student_suffix')->nullable();
            $table->date('student_birthdate');
            $table->enum('student_gender', ['male', 'female']);
            $table->string('student_birth_place')->nullable();
            $table->string('student_religion')->nullable();
            $table->string('student_nationality')->default('Filipino');
            $table->string('student_mother_tongue')->nullable();
            $table->string('student_ethnicity')->nullable();
            
            // Address
            $table->text('address');
            $table->string('barangay');
            $table->string('city');
            $table->string('province')->default('Negros Oriental');
            $table->string('zip_code')->nullable();
            
            // Previous School (for transferees)
            $table->string('previous_school')->nullable();
            $table->string('previous_school_id')->nullable();
            $table->string('previous_school_address')->nullable();
            $table->string('last_grade_completed')->nullable();
            $table->string('general_average')->nullable();
            
            // Parent/Guardian Information
            $table->string('father_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_contact')->nullable();
            $table->string('father_email')->nullable();
            
            $table->string('mother_name')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('mother_contact')->nullable();
            $table->string('mother_email')->nullable();
            
            $table->string('guardian_name'); // Required if no parent
            $table->string('guardian_relationship');
            $table->string('guardian_contact');
            $table->string('guardian_email')->nullable();
            $table->text('guardian_address')->nullable(); // If different from student
            
            // Emergency Contact
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_relationship');
            $table->string('emergency_contact_number');
            
            // Special Needs & Health
            $table->boolean('has_special_needs')->default(false);
            $table->text('special_needs_details')->nullable();
            $table->text('medical_conditions')->nullable();
            $table->text('allergies')->nullable();
            
            // Account Information (for login)
            $table->string('parent_email')->unique(); // Will be used for account
            $table->string('parent_password'); // Temporary password
            $table->boolean('account_created')->default(false);
            
            // Admin Review
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['status', 'created_at']);
            $table->index(['application_number']);
            $table->index(['student_last_name', 'student_first_name'], 'enrollment_apps_name_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_applications');
    }
};
