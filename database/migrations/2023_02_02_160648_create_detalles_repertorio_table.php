<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesRepertorioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_repertorio', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('repertorio_id')->unsigned();
            $table->foreign('repertorio_id')->references('id')->on('repertorio');
            $table->bigInteger('cancion_id')->unsigned();
            $table->foreign('cancion_id')->references('id')->on('canciones');
            $table->bigInteger('miembro_id')->unsigned();
            $table->foreign('miembro_id')->references('id')->on('miembros');
            $table->text('observacion')->nullable();
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
        Schema::dropIfExists('detalles_repertorio');
    }
}
