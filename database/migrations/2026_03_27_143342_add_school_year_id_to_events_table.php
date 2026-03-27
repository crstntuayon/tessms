<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('events', function (Blueprint $table) {
        if (!Schema::hasColumn('events', 'school_year_id')) {
            $table->foreignId('school_year_id')->nullable()->constrained('school_years')->onDelete('set null');
        }
    });
}

public function down()
{
    Schema::table('events', function (Blueprint $table) {
        $table->dropForeign(['school_year_id']);
        $table->dropColumn('school_year_id');
    });
}
};
