<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\Pet;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;

class PrescriptionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function store_prescription()
    {
        $user = User::factory()->create(['role' => 'Veterinario', ]);
        $this->actingAs($user);
        $pet = Pet::factory()->create(['id_owner' => $user->id]);
        $medicalRecord = MedicalRecord::factory()->create(['id_pet' => $pet->id]);

         $data = [
            'medication' => 'amoxicilina',
            'dosage' => '500ml',
            'instructions' => 'Cada 8 horas',
            'duration' => '1 mes',
        ];
        $response = $this->postJson('/prescriptions', $data);
        $response->assertStatus(200)
                ->assertJsonFragment([
                    'medication' => 'amoxicilina',
                    'dosage' => '500ml',
                    'instructions' => 'Cada 8 horas',
                    'duration' => '1 mes',
                ]);
        $this->assertDatabaseHas('prescriptions', [
            'medication' => 'amoxicilina',
        ]);
    }

    #[Test]
    public function download_prescription_pdf()
    {
        $prescription = Prescription::factory()->create([
            'medication' => 'Ibuprofeno',
            'dosage' => '200mg',
            'instructions' => 'Despues de comer',
            'duration' => '5 días',
        ]);
        $user = User::factory()->create(['role' => 'Cliente']);
        $this->actingAs($user);
        $response = $this->get("/prescription/{$prescription->id}/download");
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
        $response->assertDownload('prescripcion_' . $prescription->id . '.pdf');
    }
}
