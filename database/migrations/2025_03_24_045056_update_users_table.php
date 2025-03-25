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
        Schema::table('users', function (Blueprint $table) {
            // Drop unnecessary columns
            $table->dropColumn(['name', 'email', 'email_verified_at', 'remember_token']);

            // Add the columns you need
            $table->string('username')->unique();
            $table->string('role');
            $table->string('password')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert changes in case of rollback
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            // Drop the new columns added
            $table->dropColumn(['username', 'role']);
        });
    }
};
