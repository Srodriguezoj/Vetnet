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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_invoice');
            $table->string('title', 500);
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->double('unit_price', 10, 2);
            $table->double('subtotal', 10, 2);
            $table->timestamps(3);

            // Clave foránea de la tabla de facturas
            $table->foreign('id_invoice')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
