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
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            // Conectamos con la tabla vehiculos
            $table->foreignId('vehiculo_id')->constrained('vehiculos');
            
            $table->string('tipo'); // Preventivo o Correctivo
            $table->date('fecha');
            $table->integer('kilometraje'); // Kilometraje al momento de hacer el servicio
            $table->string('taller');
            $table->decimal('costo_total', 10, 2)->default(0); // Costo monetario con dos decimales
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
