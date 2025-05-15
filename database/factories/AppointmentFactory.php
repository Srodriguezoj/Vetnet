<?php

namespace Database\Factories;
use App\Models\Pet;
use App\Models\Veterinary;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_pet' => Pet::factory(),
            'id_veterinary' => Veterinary::factory(),
            'date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'time' => $this->faker->time(),
            'title' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'state' => $this->faker->randomElement(['Pendiente', 'Confirmada', 'Cancelada', 'Completada']),
            'specialty' => $this->faker->randomElement(['Interna', 'Cirugia', 'Dermatologia', 'Odontologia', 'Cardiologia', 'Preventiva', 'Etologia']),
        ];
    }
}
