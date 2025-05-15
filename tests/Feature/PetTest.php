<?php

namespace Tests\Feature;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PetTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function pet_store()
    {
        $user = User::factory()->create([
            'role' => 'Cliente',
        ]);
        $this->actingAs($user);
        $petData = [
            'name' => 'Juan',
            'breed' => 'pug',
            'num_microchip' => '1234567890', 
            'date_of_birth' => '2022-01-01',
            'sex' => 'Macho',
            'species' => 'Perro',
            'colour' => 'negro',
            'coat' => 'corto',
            'size' => 'Mediano',
            'weight' => 7,
        ];
        $response = $this->post(route('pets.store'), $petData);
        $response->assertRedirect(route('client.dashboard'));
        $this->assertDatabaseHas('pets', ['name' => 'Juan']);
    }
}
