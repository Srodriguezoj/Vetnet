<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vaccine;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vaccine>
 */
class VaccineFactory extends Factory
{
    protected $model = Vaccine::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vaccine_type' => $this->faker->word(),
            'stamp' => $this->faker->word(),
            'batch_num' => $this->faker->word(),
            'expedition_number'=> $this->faker->date(),
        ];
    }
}
