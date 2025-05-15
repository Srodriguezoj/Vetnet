<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Veterinary;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_client' => User::factory(), 
            'id_veterinary' => Veterinary::factory(),
            'date' => now(),
            'total' => $this->faker->randomFloat(2, 20, 500),
            'tax_percentage' => $this->faker->randomFloat(2, 5, 25),
            'total_with_tax' => $this->faker->randomFloat(2, 20, 500) * 1.2,
            'status' => $this->faker->randomElement(['Pendiente', 'Pagada', 'Anulada']),
        ];
    }
}
