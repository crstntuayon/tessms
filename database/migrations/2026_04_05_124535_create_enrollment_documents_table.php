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
        Schema::create('enrollment_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_application_id')->constrained()->onDelete('cascade');
            
            $table->string('document_type'); // birth_certificate, report_card, good_moral, etc.
            $table->string('document_name'); // Display name
            $table->string('file_path');
            $table->string('file_type'); // pdf, jpg, png
            $table->integer('file_size'); // in bytes
            
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            
            $table->timestamps();
            
            $table->index(['enrollment_application_id', 'document_type'], 'enrollment_docs_app_id_type_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_documents');
    }
};
