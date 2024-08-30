<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(BairroSeeder::class);
        $this->call(CupomSeeder::class);
        $this->call(AdicionalSeeder::class);
        $this->call(CategoriasCupomSeeder::class);
    }
}
