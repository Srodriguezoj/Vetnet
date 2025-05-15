<?php

namespace Tests\Feature;

use App\Models\Vaccine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class VaccineTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function store_vaccine()
    {
        $user = User::factory()->create(['role' => 'Veterinario']);
        $this->actingAs($user);
        $data = [
            'vaccine_type' => 'vacuna rabia',
            'stamp' => '2025-01-01',
            'batch_num' => '1234',
            'expedition_number' => '12345',
        ];
        $response = $this->postJson(route('vaccine.store'), $data);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'vaccine_type' => $data['vaccine_type'],
            'stamp' => $data['stamp'],
            'batch_num' => $data['batch_num'],
            'expedition_number' => $data['expedition_number'],
        ]);
        $this->assertDatabaseHas('vaccines', [
            'vaccine_type' => $data['vaccine_type'],
            'stamp' => $data['stamp'],
            'batch_num' => $data['batch_num'],
            'expedition_number' => $data['expedition_number'],
        ]);
    }

    #[Test]
    public function store_vaccine_error()
    {
        $user = User::factory()->create(['role' => 'Veterinario']);
        $this->actingAs($user);
        $data = [
            'stamp' => '2025-01-01',
            'batch_num' => '1234',
            'expedition_number' => '12345',
        ];
        $response = $this->postJson(route('vaccine.store'), $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['vaccine_type']);
    }
}