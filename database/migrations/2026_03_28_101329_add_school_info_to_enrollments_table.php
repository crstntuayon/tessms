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
        Schema::table('enrollments', function (Blueprint $table) {
            $table->string('school_name')->nullable()->after('previous_school');
            $table->string('school_id')->nullable()->after('school_name');
            $table->string('school_district')->nullable()->after('school_id');
            $table->string('school_division')->nullable()->after('school_district');
            $table->string('school_region')->nullable()->after('school_division');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn([
                'school_name',
                'school_id',
                'school_district',
                'school_division',
                'school_region'
            ]);
        });
    }
};