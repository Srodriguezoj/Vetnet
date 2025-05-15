<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Pet;
use App\Models\User;
use App\Models\Veterinary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;


class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function create_appointment()
    {
        $user = User::factory()->create(['role' => 'Cliente',]);
        $veterinary = Veterinary::factory()->create();
        $pet = Pet::factory()->create();

        $this->actingAs($user);

        $data = [
            'id_pet' => $pet->id,
            'id_veterinary' => $veterinary->id,
            'specialty' => 'Interna',
            'date' => '2025-05-15',
            'time' => '10:00',
            'title' => 'Consulta General',
            'description' => 'Chequeo rutinario',
        ];

        $response = $this->post(route('appointments.store'), $data);

        $response->assertRedirect(route('client.dashboard'));
        $this->assertDatabaseHas('appointments', [
            'id_pet' => $pet->id,
            'id_veterinary' => $veterinary->id,
            'specialty' => 'Interna',
            'date' => '2025-05-15',
            'time' => '10:00',
            'title' => 'Consulta General',
            'description' => 'Chequeo rutinario',
            'state' => 'Pendiente',
        ]);
    }

    #[Test]
    public function cancel_appointment()
    {
        $user = User::factory()->create(['role' => 'Cliente']);
        $this->actingAs($user);
        $pet = Pet::factory()->create();
        $veterinary = Veterinary::factory()->create();
        $appointment = Appointment::factory()->create([
            'state' => 'Pendiente',
            'id_pet' => $pet->id,
            'id_veterinary' => $veterinary->id,
        ]);
        $response = $this->delete(route('appointments.destroy', ['appointment' => $appointment->id]));
        $response->assertRedirect(route('client.showPet', ['pet' => $appointment->id_pet]));
    }

    #[Test]
    public function check_veterinary_availability()
    {
        $user = User::factory()->create(['role' => 'Cliente']);
        $this->actingAs($user);
        $veterinary = Veterinary::factory()->create();
        $pet = Pet::factory()->create();
        $data = [
            'specialty' => 'Interna',
            'date' => '2025-05-15',
            'time' => '10:00',
        ];
        Appointment::factory()->create([
            'id_veterinary' => $veterinary->id,
            'specialty' => 'Interna',
            'date' => '2025-05-15',
            'time' => '10:00',
        ]);
         $response = $this->get(route('client.showPet', ['pet' => $pet->id]), $data);
         $response->assertStatus(200);
    }

    #[Test]
    public function update_appointment_state()
    {
        $user = User::factory()->create(['role' => 'Veterinario']);
        $this->actingAs($user);
        $appointment = Appointment::factory()->create([
            'state' => 'Pendiente'
        ]);

        $response = $this->put(route('appointments.updateState', ['appointment' => $appointment, 'state' => 'Confirmada']));

        $response->assertRedirect(route('veterinary.showDates'));
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'state' => 'Confirmada',
        ]);
    }
}
