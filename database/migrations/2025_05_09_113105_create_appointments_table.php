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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pet');
            $table->unsignedBigInteger('id_veterinary');
            $table->date('date');
            $table->time('time');
            $table->string('title', 200);
            $table->text('description');
            $table->enum('state', ['Pendiente', 'Confirmada', 'Cancelada', 'Completada']);
            $table->enum('specialty', ['Interna', 'Cirugia', 'Dermatologia', 'Odontologia', 'Cardiologia', 'Preventiva', 'Etologia']);
            $table->timestamps(3);

            // Claves foráneas de las tablas de mascota y veterinario
            $table->foreign('id_pet')->references('id')->on('pets')->onDelete('cascade');
            $table->foreign('id_veterinary')->references('id')->on('veterinaries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
