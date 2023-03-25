<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** 
 * Esta migración sirve para crear la tabla Viajes, con los campos:
 * nombre
 * apellido
 * documento
 * organismo
 * viaticos
 * fecha_inicio
 * fecha_fin
 */ 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('viajes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); 
            $table->string('apellido');
            $table->string('documento');
            $table->string('organismo');
            $table->decimal('viaticos', 10, 2); // Define la columna viaticos, con 10 dígitos y 2 decimales.
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viajes');
    }
};
