<?php
namespace Database\Factories;

use App\Models\Slot;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Carbon\Carbon;


class SlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

    $service = Service::factory()->create();
        return [
          'date' => '2023-05-30',
          'start_time' => '10:00:00',
          'end_time' => '12:00:00',
          'capacity' => 1,
          'service_id' => $service->id,
        ];
    }
}
