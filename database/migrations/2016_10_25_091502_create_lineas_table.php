<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plantillazona_id');
            $table->string('maquina');
            $table->string('usuario');
            $table->integer('monedas')->unsigned()->default(0);
            $table->integer('bv')->unsigned()->default(0);
            $table->integer('bx')->unsigned()->default(0);
            $table->integer('bxx')->unsigned()->default(0);
            $table->integer('bl')->unsigned()->default(0);
            $table->integer('bc')->unsigned()->default(0);
            $table->integer('billetes')->unsigned()->default(0);
            $table->integer('total')->unsigned()->default(0);
            $table->integer('monedasI')->unsigned()->default(0);
            $table->integer('billetesI')->unsigned()->default(0);
            $table->integer('totalI')->unsigned()->default(0);
            $table->integer('diferencia')->unsigned()->default(0);

            $table->boolean('verificado')->default(0);
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
        Schema::dropIfExists('lineas');
    }
}
