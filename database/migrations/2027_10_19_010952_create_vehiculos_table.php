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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            //  Conectamos con la tabla choferes
            $table->foreignId('chofer_id')->constrained('choferes');
            
            $table->string('placa')->unique(); // La placa no se puede repetir
            $table->string('marca');
            $table->string('modelo');
            $table->integer('anio');
            $table->integer('kilometraje_actual'); // Clave para las alertas de 10.000 km
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
