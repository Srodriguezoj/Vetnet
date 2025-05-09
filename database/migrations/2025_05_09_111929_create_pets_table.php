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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_owner')->constrained('users')->onDelete('cascade');
            $table->string('num_microchip', 15)->unique();
            $table->string('name', 100);
            $table->dateTime('date_of_birth', 3);
            $table->enum('sex', ['Macho', 'Hembra']);
            $table->enum('species', ['Perro', 'Gato', 'Huron']);
            $table->string('breed', 300);
            $table->string('colour', 200);
            $table->string('coat', 150);
            $table->enum('size', ['Grande', 'Mediano', 'Pequeño']);
            $table->double('weight');
            $table->timestamps(3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
