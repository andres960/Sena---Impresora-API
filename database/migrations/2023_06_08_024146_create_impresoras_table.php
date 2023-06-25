<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImpresorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impresoras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_encargado')->nullable();
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->string('Modelo');
            $table->string('Marca');
            $table->string('NroSerie');
            $table->string('Conectividad');
            $table->string('Resolucion');
            $table->string('Estado_tinta');
            $table->string('Estado_impresora');
            $table->string('Estado_taller');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('impresoras');
    }
}
