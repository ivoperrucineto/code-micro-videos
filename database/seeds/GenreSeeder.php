<?php

use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run()
    {
        factory(\App\Models\Genre::class, 15)->create();
    }
}
