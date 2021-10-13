<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumne;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Alumne::factory()->times(50)->create();
    }
}
