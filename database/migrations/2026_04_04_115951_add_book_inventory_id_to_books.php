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
Schema::table('books', function (Blueprint $table) {
    $table->foreignId('book_inventory_id')
          ->nullable()
          ->constrained()
          ->nullOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            //
            $table->dropForeign(['book_inventory_id']);
            $table->dropColumn('book_inventory_id');    
            
        });
    }
};
