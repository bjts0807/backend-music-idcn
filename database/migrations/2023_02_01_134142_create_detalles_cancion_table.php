<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesCancionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_cancion', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cancion_id')->unsigned();
            $table->foreign('cancion_id')->references('id')->on('canciones');
            $table->text('nombre');
            $table->text('contenido');
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
        Schema::dropIfExists('detalles_cancion');
    }
}
