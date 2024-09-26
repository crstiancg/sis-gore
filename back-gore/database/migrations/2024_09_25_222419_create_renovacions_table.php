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
        Schema::create('renovacions', function (Blueprint $table) {
            $table->id();
            $table->char('anio', 4)->nullable();
            $table->enum('tipo',['FIEL CUMPLIMIENTO','ADELANTO DIRECTO','ADELANTO DE MATERIALES'])->nullable();
            $table->string('numero_llegada')->nullable();
            $table->date('fecha_incial')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->string('numero_carta')->nullable();
            $table->string('folios')->nullable();
            $table->string('oficio_notificado')->nullable();
            $table->string('tipo_proceso', 500)->nullable();
            $table->string('oficio_efectivizacion', 500)->nullable();
            $table->string('estado_carta', 500)->nullable();
            $table->foreignId('entidad_id')->constrained()->nullable();
            $table->foreignId('carta_id')->constrained()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renovacions');
    }
};
