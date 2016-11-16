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
            $table->integer('maquina_id');
            $table->string('maquina');
            $table->string('usuario');
            $table->decimal('monedas',5,2)->unsigned()->default(0);
            $table->integer('bv')->unsigned()->default(0);
            $table->integer('bx')->unsigned()->default(0);
            $table->integer('bxx')->unsigned()->default(0);
            $table->integer('bl')->unsigned()->default(0);
            $table->integer('bc')->unsigned()->default(0);
            $table->integer('billetes')->unsigned()->default(0);
            $table->decimal('total',6,2)->unsigned()->default(0);
            $table->decimal('monedasI',5,2)->unsigned()->default(0);
            $table->integer('billetesI')->unsigned()->default(0);
            $table->decimal('totalI',6,2)->unsigned()->default(0);
            $table->decimal('diferencia',6,2)->default(0);

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
