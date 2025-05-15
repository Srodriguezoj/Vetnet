<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Veterinary;
use App\Models\Appointment;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function create_invoice()
    {
        $veterinarian = User::factory()->create(['role' => 'Veterinario']);
        $this->actingAs($veterinarian);
        $client = User::factory()->create();
        $appointment = Appointment::factory()->create();
        $veterinary = Veterinary::factory()->create([
            'id_user' => $veterinarian->id,
        ]);
        $data = [
            'id_client' => $client->id,
            'id_veterinary' => $veterinary ? $veterinary->id : null,
            'id_appointment' => $appointment->id,
            'date' => now()->toDateTimeString(),
            'status' => 'Pendiente',
            'items' => json_encode([
                [
                    'title' => 'Consulta veterinaria',
                    'unit_price' => 50,
                    'subtotal' => 50,
                    'description' => 'Consulta',
                    'quantity' => 1,
                    'price' => 50,
                ]
            ]),
            'total' => 50,
            'tax_percentage' => 21,
            'total_with_tax' => 60.5,
        ];
        $response = $this->postJson(route('invoices.store'), $data);
        $response->assertStatus(200);
    }


    #[Test]
    public function concept_no_valid()
    {
        $user = User::factory()->create();
        $veterinary = Veterinary::factory()->create();
        $user2 = User::factory()->create(['role' => 'Admin']);
        $this->actingAs($user2);
        $appointment = Appointment::factory()->create();
        $data = [
            'id_client' => $user->id,
            'id_veterinary' => $veterinary->id,
            'id_appointment' => $appointment->id,
            'date' => now(),
            'status' => 'Pendiente',
            'items' => 'concepto erroneo',
            'total' => 50,
            'tax_percentage' => 21,
            'total_with_tax' => 60.5,
        ];
        $response = $this->postJson(route('invoices.store'), $data);
        $response->assertStatus(400)
            ->assertJson(['message' => 'Formato de ítems inválido']);
    }

    #[Test]
    public function changes_invoice_status()
    {
        $user = User::factory()->create();
        $veterinary = Veterinary::factory()->create();
        $user2 = User::factory()->create(['role' => 'Admin']);
        $this->actingAs($user2);
        $appointment = Appointment::factory()->create();
        $invoice = Invoice::factory()->create([
            'id_client' => $user->id,
            'id_veterinary' => $veterinary->id,
            'status' => 'Pendiente',
        ]);
        $data = ['status' => 'Pagada'];
        $response = $this->postJson(route('invoice.changeState', $invoice->id), $data);

        $response->assertStatus(302);
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => 'Pagada',
        ]);
    }
}
