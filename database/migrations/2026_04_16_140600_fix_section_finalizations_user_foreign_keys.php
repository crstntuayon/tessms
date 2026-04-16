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
        Schema::table('section_finalizations', function (Blueprint $table) {
            $table->dropForeign(['finalized_by']);
            $table->dropForeign(['unlocked_by']);

            $table->foreign('finalized_by')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->foreign('unlocked_by')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('section_finalizations', function (Blueprint $table) {
            $table->dropForeign(['finalized_by']);
            $table->dropForeign(['unlocked_by']);

            $table->foreign('finalized_by')
                ->references('id')->on('users');

            $table->foreign('unlocked_by')
                ->references('id')->on('users');
        });
    }
};
