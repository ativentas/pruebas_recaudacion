<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ZonasTableSeeder::class);
        $this->call(EstancosTableSeeder::class);
        $this->call(MaquinasTableSeeder::class);
        $this->call(UsersTableSeeder::class);

    }
}
