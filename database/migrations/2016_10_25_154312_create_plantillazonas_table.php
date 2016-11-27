<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantillazonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantillazonas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->string('semana');
            $table->string('zona');
            $table->string('year');
            $table->boolean('archivado')->default(0);
            $table->decimal('totalAnterior',7,2)->unsigned()->default(0);
            $table->decimal('monedasR',7,2)->unsigned()->default(0);
            $table->integer('bv')->unsigned()->default(0);
            $table->integer('bx')->unsigned()->default(0);
            $table->integer('b2x')->unsigned()->default(0);
            $table->integer('bl')->unsigned()->default(0);
            $table->integer('bc')->unsigned()->default(0);
            $table->integer('billetesR')->unsigned()->default(0);
            $table->decimal('totalR',7,2)->unsigned()->default(0);
            $table->decimal('pagos',6,2)->unsigned()->default(0);
            $table->decimal('monedasL',7,2)->unsigned()->default(0);
            $table->integer('billetesL')->unsigned()->default(0);
            $table->decimal('totalL',7,2)->unsigned()->default(0);
            $table->decimal('diferencia',7,2)->default(0);
            $table->decimal('acumular',7,2)->unsigned()->default(0);
            $table->decimal('descuadre',7,2)->default(0);

            $table->decimal('diferencia',7,2)->default(0);

            $table->nullableTimestamps();

            $table->unique(['zona', 'fecha']);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plantillazonas');
    }
}
