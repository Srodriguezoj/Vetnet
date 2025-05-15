<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Veterinary;
use App\Models\Appointment;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VeterinaryTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function create_veterinary()
    {
        $data = [
            'name' => 'Juan',
            'surname' => 'Lopez',
            'email' => 'juan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'collegiate_num' => '12345ABC',
            'specialty' => 'Cirugia',
            'dni' => '12345678R',
        ];

        $this->actingAs(User::factory()->create([
            'role' => 'Admin',
            'dni' => '00000001A',
        ]));

        $response = $this->post(route('veterinary.store'), $data);

        $this->assertDatabaseHas('veterinaries', [
            'collegiate_num' => '12345ABC',
            'specialty' => 'Cirugia',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'juan@example.com',
            'role' => 'Veterinario',
        ]);

        $response->assertRedirect(route('veterinary.showVeterinaries'));
    }
    #[Test]
    public function delete_veterinary()
    {
        $admin = User::factory()->create([
            'role' => 'Admin',
            'dni' => '00000002B',
        ]);
        $this->actingAs($admin);

        $user = User::factory()->create([
            'role' => 'Veterinario',
            'dni' => '00000003C',
        ]);

        $veterinary = Veterinary::factory()->create(['id_user' => $user->id]);
        $response = $this->delete(route('veterinary.delete', $veterinary->id));
        $this->assertDatabaseMissing('veterinaries', ['id' => $veterinary->id]);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $response->assertRedirect(route('veterinary.showVeterinaries'));
    }

     #[Test]
    public function show_veterinaries()
    {
        $admin = User::factory()->create([
            'role' => 'Admin',
            'dni' => '11223344D',
        ]);
        $this->actingAs($admin);
        $veterinary1 = Veterinary::factory()->create();
        $veterinary2 = Veterinary::factory()->create();
        $response = $this->get(route('veterinary.showVeterinaries'));
        $response->assertStatus(200);
        $response->assertSee($veterinary1->collegiate_num);
        $response->assertSee($veterinary2->collegiate_num);
    }

     #[Test]
    public function show_dates()
    {
        $veterinaryUser = User::factory()->create([
            'role' => 'Veterinario',
            'dni' => '00000005E',
        ]);
        $this->actingAs($veterinaryUser);
        $veterinary = Veterinary::factory()->create(['id_user' => $veterinaryUser->id]);
        $appointment = Appointment::factory()->create(['id_veterinary' => $veterinary->id]);
        $response = $this->get(route('veterinary.showDates'));
        $response->assertStatus(200);
        $response->assertSee($appointment->id);
    }

     #[Test]
    public function show_invoices()
    {
        $adminUser = User::factory()->create([
            'role' => 'Admin',
            'dni' => '00000007G',
        ]);
        $this->actingAs($adminUser);
        $veterinaryUser = User::factory()->create([
            'role' => 'Veterinario',
            'dni' => '00000006F',
        ]);
        $veterinary = Veterinary::factory()->create(['id_user' => $veterinaryUser->id]);
        $invoice = Invoice::factory()->create(['id_veterinary' => $veterinary->id]);
        $response = $this->get(route('veterinary.showInvoices'));
        $response->assertStatus(200);
        $response->assertSee($invoice->id);
    }
    #[Test]
    public function testUnauthorizedAccess()
    {
       $response = $this->get(route('veterinary.showVeterinaries'));
        $response->assertRedirect(route('login'));
    }
}
