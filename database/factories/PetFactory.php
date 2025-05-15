<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            return [
            'name' => $this->faker->firstName,
            'num_microchip' => $this->faker->unique()->regexify('[0-9]{8}[A-Z]'),
            'species' => 'perro',
            'breed' => 'pug',
            'colour' => 'black',
            'coat' => 'Mucho',
            'weight' => '6',
            'date_of_birth' => $this->faker->date(),
            'sex' => 'macho',
            'id_owner' => User::factory(),
        ];
    }
}
