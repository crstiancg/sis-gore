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
        Schema::create('entidads', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->enum('tipo', ['BANCO', 'FINANCIERA', 'CAJA MUNICIPAL AC', 'CAJA RURAL AC'])->comment('BANCO - FINANCIERA - CAJA MUNICIPAL DE AHORRO Y CRÉDITO - CAJA RURAL DE AHORRO Y CRÉDITO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entidads');
    }
};
