<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grade_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Grade 1", "Grade 2"
            $table->timestamps();
        });

        // Optionally, seed some default grade levels
        DB::table('grade_levels')->insert([
            ['name' => 'Kindergarten', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Grade 1', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Grade 2', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Grade 3', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Grade 4', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Grade 5', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Grade 6', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_levels');
    }
};