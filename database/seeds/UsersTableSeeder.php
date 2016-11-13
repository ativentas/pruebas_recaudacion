<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	[
            'name' => 'alberto',
            'email' => 'josezara1@gmail.com',
            'password' => bcrypt('tomate'),
            'is_admin' => true,
        	],
        	[
        	'name' => 'carol',
            'email' => 'josezara2@gmail.com',
            'password' => bcrypt('carol'),
        	]
        ]);
    }
}
