<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('messages')->cascadeOnDelete()->after('id');
            $table->foreignId('section_id')->nullable()->constrained('sections')->cascadeOnDelete()->after('recipient_id');
            $table->boolean('is_bulk')->default(false)->after('is_read');
            $table->timestamp('read_at')->nullable()->after('is_read');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['section_id']);
            $table->dropColumn(['parent_id', 'section_id', 'is_bulk', 'read_at']);
            $table->dropSoftDeletes();
        });
    }
};
