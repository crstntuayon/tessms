<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('announcements', function (Blueprint $table) {
        $table->string('target')->default('students'); // or 'all', 'teachers', etc.
        $table->boolean('is_read')->default(false);
    });
}

public function down()
{
    Schema::table('announcements', function (Blueprint $table) {
        $table->dropColumn(['target', 'is_read']);
    });
}
};
