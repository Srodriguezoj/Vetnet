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
        Schema::create('pet_vaccinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pet');
            $table->unsignedBigInteger('id_vaccine');
            $table->unsignedBigInteger('id_medical_record');
            $table->date('date_administered');
            $table->timestamps(3);

            // Claves foráneas que relaciona la vacuna con la mascota, el tipo de vacuna y el registro donde se administro
            $table->foreign('id_pet')->references('id')->on('pets')->onDelete('cascade');
            $table->foreign('id_vaccine')->references('id')->on('vaccines')->onDelete('cascade');
            $table->foreign('id_medical_record')->references('id')->on('medical_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_vaccinations');
    }
};
