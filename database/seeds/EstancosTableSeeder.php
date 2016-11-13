<?php

use Illuminate\Database\Seeder;

class EstancosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estancos')->insert([
        	[
            'nombre' => 'MARIA',
        	],
        	[
            'nombre' => 'ALBERTO',
        	],      	
        ]);
    }
}
