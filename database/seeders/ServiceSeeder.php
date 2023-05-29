<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\BusinessAdministrator;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $business_admin = BusinessAdministrator::where('name', 'Hasnat Raza')->first();

        $business_admin->services()->create([
            'name' => 'Men Haircut',
            'slot_duration' => 30,
            'capacity' => 3,
            'after_service_time' => 5,
            'booking_time_limit' => 7,
        ]);

        $business_admin->services()->create([
            'name' => 'Women Haircut',
            'slot_duration' => 60,
            'capacity' => 3,
            'after_service_time' => 10,
            'booking_time_limit' => 7,
        ]);
    }
}
