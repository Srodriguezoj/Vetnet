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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_client');
            $table->unsignedBigInteger('id_veterinary');
            $table->date('date');
            $table->double('total', 10, 2);
            $table->double('tax_percentage', 5, 2);
            $table->double('total_with_tax', 10, 2);
            $table->enum('status', ['Pendiente', 'Pagada', 'Anulada']);
            $table->timestamps(3);

            // Claves foráneas de las tablas de cliente y veterinario
            $table->foreign('id_client')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_veterinary')->references('id')->on('veterinaries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
