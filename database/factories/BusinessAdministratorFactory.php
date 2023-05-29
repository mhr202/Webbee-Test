<?php
namespace Database\Factories;

use App\Models\BusinessAdministrator;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class BusinessAdministratorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'name' => 'John Doe',
          'description' => 'This is a business administrator',
        ];
    }
}
