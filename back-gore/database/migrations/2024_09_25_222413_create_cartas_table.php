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
        Schema::create('cartas', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 14, 2)->nullable();
            $table->string('contratista', 500)->nullable();
            $table->string('dependencia', 500)->nullable();
            $table->char('meta_id', 4)->nullable();
            $table->char('procedimiento_id', 2)->nullable();
            $table->string('denominacion', 400)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartas');
    }
};
