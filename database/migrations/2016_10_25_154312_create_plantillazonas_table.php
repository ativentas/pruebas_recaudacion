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
            $table->string('semana');
            $table->string('zona');
            $table->string('year');
            $table->boolean('extra')->default(0);
            $table->string('primerdia');
            $table->string('ultimodia');
            $table->decimal('total',5,1)->unsigned()->default(0);
            $table->decimal('totalI',5,1)->unsigned()->default(0);
            $table->decimal('totalAnterior',5,1)->unsigned()->default(0);
            $table->decimal('diferencia',5,1)->default(0);
            $table->boolean('archivado')->default(0);
            $table->nullableTimestamps();

            $table->index(['zona', 'semana', 'year', 'extra']);
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
