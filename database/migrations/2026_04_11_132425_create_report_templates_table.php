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
        Schema::create('report_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('category'); // academic, attendance, financial, compliance, etc.
            $table->string('type'); // table, chart, combined
            $table->json('columns'); // report column definitions
            $table->json('filters'); // available filters
            $table->json('chart_config')->nullable(); // chart configuration for visual reports
            $table->json('default_params')->nullable(); // default filter parameters
            $table->text('icon')->nullable(); // icon class
            $table->string('color')->nullable(); // theme color
            $table->boolean('is_system')->default(false); // system vs user-created
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            $table->index(['category', 'is_active']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_templates');
    }
};
