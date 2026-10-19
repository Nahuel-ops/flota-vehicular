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
        Schema::create('mantenimiento_repuesto', function (Blueprint $table) {
            $table->id();
            //  Puentes de conexión con las dos tablas principales
            $table->foreignId('mantenimiento_id')->constrained('mantenimientos');
            $table->foreignId('repuesto_id')->constrained('repuestos');
            
            // Columnas requeridas por el caso de estudio
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2); 
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimiento_repuesto');
    }
};
