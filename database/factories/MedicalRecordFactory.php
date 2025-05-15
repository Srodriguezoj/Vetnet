<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MedicalRecord;
use App\Models\Pet;
use App\Models\Veterinary;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\Invoice;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    protected $model = MedicalRecord::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            'id_pet' => Pet::factory(),
            'id_veterinary' => Veterinary::factory(),
            'id_appointment' => Appointment::factory(),
            'diagnosis' => $this->faker->sentence(),
            'id_prescription' => Prescription::factory(),
            'id_invoice' => Invoice::factory(),
        ];
    }
}
