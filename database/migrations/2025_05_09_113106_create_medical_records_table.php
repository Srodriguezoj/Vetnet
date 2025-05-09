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
        Schema::create('medical_records', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_pet');
        $table->unsignedBigInteger('id_veterinary');
        $table->unsignedBigInteger('id_appointment');
        $table->unsignedBigInteger('id_prescription')->nullable();
        $table->unsignedBigInteger('id_invoice')->nullable();
        $table->text('diagnosis');
        $table->timestamps();

        // Definir las claves foráneas
        $table->foreign('id_pet')->references('id')->on('pets')->onDelete('cascade');
        $table->foreign('id_veterinary')->references('id')->on('veterinaries')->onDelete('cascade');
        $table->foreign('id_appointment')->references('id')->on('appointments')->onDelete('cascade');
        $table->foreign('id_prescription')->references('id')->on('prescriptions')->onDelete('set null');  
        $table->foreign('id_invoice')->references('id')->on('invoices')->onDelete('set null'); 
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
