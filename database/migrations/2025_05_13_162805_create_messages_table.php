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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_client');
            $table->string('title', 500)->nullable();
            $table->text('subject')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->enum('status', ['Leido', 'No leido'])->default('No leido');
            $table->timestamps();

            $table->foreign('id_client')->references('id')->on('users')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
