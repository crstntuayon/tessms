<?php
// database/migrations/xxxx_xx_xx_add_settings_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // JSON column for flexible settings storage
            $table->json('settings')->nullable()->after('remember_token');
            
            // Separate column for 2FA (frequently accessed)
            $table->boolean('two_factor_enabled')->default(false)->after('settings');
            $table->string('two_factor_secret')->nullable()->after('two_factor_enabled');
            $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'settings',
                'two_factor_enabled',
                'two_factor_secret',
                'two_factor_recovery_codes'
            ]);
        });
    }
};