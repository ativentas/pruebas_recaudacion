<?php

use Illuminate\Database\Seeder;

class PlantillasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plantillazonas')->insert([
        	[
            'semana' => '43',
            'zona' => 'Burjassot',
            'year' => '2016',
        	],
        	[
            'semana' => '43',
            'zona' => 'Valencia',
            'year' => '2016',
        	],
        	[
            'semana' => '43',
            'zona' => 'Lliria',
            'year' => '2016',
        	],        	
        ]);
    }
}
