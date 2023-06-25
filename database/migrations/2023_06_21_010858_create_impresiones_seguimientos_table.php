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
        Schema::create('impresoras_seguimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_administrador')->nullable();
            $table->unsignedBigInteger('id_impresora')->nullable();
            $table->string('Descripcion');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impresiones_seguimientos');
    }
};
