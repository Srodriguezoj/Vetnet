<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeterinariesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('veterinaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('collegiate_num', 10)->unique();
            $table->enum('specialty', [
                'Interna', 'Cirugia', 'Dermatologia', 'Odontologia', 
                'Cardiologia', 'Preventiva', 'Etologia'
            ]);
            $table->timestamps(3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veterinaries');
    }
};
