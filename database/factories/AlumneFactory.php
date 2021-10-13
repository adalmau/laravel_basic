<?php

namespace Database\Factories;

use App\Models\Alumne;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Alumne::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "nom" => $this->faker->firstName,
            "cognoms" => $this->faker->lastName . " " . $this->faker->lastName, 
            "data_naixement" => $this->faker->date($format = 'Y-m-d', $max = 'now')
        ];
    }
}
