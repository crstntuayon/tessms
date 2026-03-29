<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('students', function (Blueprint $table) {
        $table->string('remarks', 20)->nullable(); // replace 'some_column' with column after which you want remarks
    });
}

public function down()
{
    Schema::table('students', function (Blueprint $table) {
        $table->dropColumn('remarks');
    });
}
};
