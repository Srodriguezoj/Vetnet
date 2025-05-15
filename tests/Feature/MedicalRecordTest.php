<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\Pet;
use App\Models\Veterinary;
use App\Models\User;
use App\Models\MedicalRecord;
use App\Models\PetVaccination;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class MedicalRecordTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function store_medical_record()
    {
        $pet = Pet::factory()->create();
        $veterinary = Veterinary::factory()->create();
        $appointment = Appointment::factory()->create(['id_pet' => $pet->id]);
        $prescription = Prescription::factory()->create();
        $user = User::factory()->create(['role' => 'Veterinario']);
        $this->actingAs($user);
        $response = $this->post(route('medicalRecords.store'), [
            'id_pet' => $pet->id,
            'id_veterinary' => $veterinary->id,
            'id_appointment' => $appointment->id,
            'diagnosis' => 'Diagnóstico de prueba',
            'id_prescription' => $prescription->id,
        ]);
        $response->assertRedirect(route('veterinary.showDates'));
        $response->assertSessionHas('success', 'Historial médico creado correctamente.');
        $this->assertDatabaseHas('medical_records', [
            'id_pet' => $pet->id,
            'diagnosis' => 'Diagnóstico de prueba',
        ]);
        $appointment->refresh();
        $this->assertEquals('Completada', $appointment->state);
    }

    #[Test]
    public function store_medical_record_error()
    {
        $appointment = Appointment::factory()->create();
        $user = User::factory()->create(['role' => 'Veterinario']);
        $this->actingAs($user);
        $response = $this->post(route('medicalRecords.store'), [
            'id_veterinary' => $user->id,
            'id_appointment' => $appointment->id,
            'diagnosis' => 'Diagnóstico de prueba',
        ]);
        $response->assertSessionHasErrors('id_pet');
    }

    #[Test]
    public function show_medical_record_client()
    {
        $pet = Pet::factory()->create();
        $medicalRecord = MedicalRecord::factory()->create(['id_pet' => $pet->id]);
        $user = User::factory()->create(['role' => 'Cliente']);
        $this->actingAs($user);
        $response = $this->get(route('medicalRecords.show', ['medicalRecord' => $medicalRecord->id]));
        $response->assertStatus(200);
        $response->assertViewHas('medicalRecord', $medicalRecord);
    }

    #[Test]
    public function show_medical_record_veterinary()
    {
        $pet = Pet::factory()->create();
        $medicalRecord = MedicalRecord::factory()->create(['id_pet' => $pet->id]);
        $user = User::factory()->create(['role' => 'Veterinario']);
        $this->actingAs($user);
        $response = $this->get(route('veterinary.medicalRecords.show', ['pet' => $pet->id, 'medicalRecord' => $medicalRecord->id]));
        $response->assertStatus(200);
        $response->assertViewHas('medicalRecord', $medicalRecord);
    }
}
