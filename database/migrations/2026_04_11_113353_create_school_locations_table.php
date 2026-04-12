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
        Schema::create('school_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('main_campus')->comment('main_campus, annex, etc.');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->integer('radius_meters')->default(100)->comment('Allowed radius for attendance');
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('require_location')->default(true)->comment('Require location verification for attendance');
            $table->text('allowed_schedules')->nullable()->comment('JSON array of allowed time slots');
            $table->timestamps();
            
            $table->index(['latitude', 'longitude']);
            $table->index('is_active');
        });

        // Insert default location for Tugawe Elementary School
        DB::table('school_locations')->insert([
            'name' => 'Tugawe Elementary School - Main Campus',
            'type' => 'main_campus',
            'latitude' => 9.1833,  // Approximate coordinates for Dauin, Negros Oriental
            'longitude' => 123.2667,
            'radius_meters' => 150,
            'address' => 'Tugawe, Dauin, Negros Oriental, Philippines',
            'is_active' => true,
            'require_location' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_locations');
    }
};
