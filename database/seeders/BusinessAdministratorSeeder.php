<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessAdministrator;

class BusinessAdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BusinessAdministrator::firstOrCreate([
            'name' => 'Hasnat Raza',
            'description' => 'This is seeded BA'
        ]);
    }
}
