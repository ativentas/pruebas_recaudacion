<?php

use Illuminate\Database\Seeder;

class ZonasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('zonas')->insert([
        	[
            'nombre' => 'Burjassot',
        	],
        	[
            'nombre' => 'Lliria',
        	],
        	[
            'nombre' => 'Valencia',
        	],        	
        ]);
    }
}
