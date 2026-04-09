<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->unsignedBigInteger('author_id')->nullable()->after('id');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');

            $table->string('scope')->default('school')->after('target'); // 'section', 'grade', 'school', 'all'
            $table->unsignedBigInteger('target_id')->nullable()->after('scope'); // section_id or grade_level_id

            $table->string('priority')->default('normal')->after('message'); // 'normal', 'important', 'urgent'
            $table->boolean('pinned')->default(false)->after('priority');
            $table->timestamp('expires_at')->nullable()->after('pinned');
            $table->unsignedBigInteger('school_year_id')->nullable()->after('expires_at');
            $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropForeign(['school_year_id']);
            $table->dropColumn(['author_id', 'scope', 'target_id', 'priority', 'pinned', 'expires_at', 'school_year_id']);
        });
    }
};
