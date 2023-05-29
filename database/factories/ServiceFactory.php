<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BusinessAdministrator;

class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => '1',
            'name' => "Service 1",
            'slot_duration' => 10,
            'after_service_time' => 10,
            'capacity' => 10,
            'booking_time_limit' => 10,
            'business_administrator_id' => function () {
                return BusinessAdministrator::factory()->create()->id;
            },
        ];
    }
}
