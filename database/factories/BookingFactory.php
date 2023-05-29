<?php
namespace Database\Factories;

use App\Models\Booking;
use App\Models\Slot;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
      $slot = Slot::factory()->create();

      return [
        'user_first_name' => 'John',
        'user_last_name' => 'Doe',
        'user_email' => 'example@gmail.com',
        'slot_id' => $slot->id,
    ];
    }
}