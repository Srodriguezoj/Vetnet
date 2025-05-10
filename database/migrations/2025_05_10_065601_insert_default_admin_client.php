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
        DB::table('users')->insert([
        'name' => 'Admin',
        'surname' => 'Vetnet',
        'email' => 'admin@vetnet.com',
        'password' => Hash::make('admin1234'),
        'role' => 'Admin',
        'dni' => '00000000A',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('email', 'admin@vetapp.com')->delete();
    }
};
