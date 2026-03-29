<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('settings');

        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Core
            $table->string('key')->unique();
            $table->text('value')->nullable();

            // Metadata
            $table->string('type')->default('string'); // string, integer, boolean, json
            $table->string('group')->default('general'); // general, school, academic, etc.
            $table->text('description')->nullable();

            // Optional enhancements (VERY USEFUL 🔥)
            $table->boolean('is_public')->default(false); // can be exposed in frontend
            $table->boolean('is_editable')->default(true); // editable in admin panel
            $table->integer('sort_order')->default(0); // UI ordering

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};