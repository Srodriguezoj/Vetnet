<?php

namespace Database\Factories;

use App\Models\Prescription;
use App\Models\MedicalRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prescription>
 */
class PrescriptionFactory extends Factory
{
    protected $model = Prescription::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'medication' => $this->faker->word(),
            'dosage' => $this->faker->word(),
            'instructions' => $this->faker->word(),
            'duration' => $this->faker->word(),
        ];
    }
}
