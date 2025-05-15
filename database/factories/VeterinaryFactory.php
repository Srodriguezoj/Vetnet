<?php

namespace Database\Factories;

use App\Models\Veterinary;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Veterinary>
 */
class VeterinaryFactory extends Factory
{
    protected $model = Veterinary::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition()
    {
        return [
                'collegiate_num' => $this->faker->unique()->numerify('#####'),
                'specialty' => $this->faker->randomElement([
                'Interna', 'Cirugia', 'Dermatologia', 'Odontologia',
                'Cardiologia', 'Preventiva', 'Etologia'
            ]),
            'id_user' => \App\Models\User::factory(),
        ];
    }
}
