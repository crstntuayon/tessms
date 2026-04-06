<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Document fields for registration
            $table->string('birth_certificate_path')->nullable()->after('status');
            $table->string('report_card_path')->nullable()->after('birth_certificate_path');
            $table->string('good_moral_path')->nullable()->after('report_card_path');
            $table->string('transfer_credential_path')->nullable()->after('good_moral_path');
            
            // Registration status tracking
            $table->enum('registration_status', ['pending', 'complete', 'incomplete'])->default('pending')->after('transfer_credential_path');
            $table->timestamp('documents_verified_at')->nullable()->after('registration_status');
            $table->foreignId('documents_verified_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'birth_certificate_path',
                'report_card_path',
                'good_moral_path',
                'transfer_credential_path',
                'registration_status',
                'documents_verified_at',
                'documents_verified_by'
            ]);
        });
    }
};
