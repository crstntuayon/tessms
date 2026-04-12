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
        Schema::table('attendances', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('remarks');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->decimal('accuracy', 8, 2)->nullable()->after('longitude')->comment('Accuracy in meters');
            $table->boolean('location_verified')->default(false)->after('accuracy');
            $table->decimal('distance_from_school', 8, 2)->nullable()->after('location_verified')->comment('Distance in meters');
            $table->string('location_status', 20)->nullable()->after('distance_from_school')->comment('within_range, out_of_range, no_signal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'latitude',
                'longitude',
                'accuracy',
                'location_verified',
                'distance_from_school',
                'location_status'
            ]);
        });
    }
};
