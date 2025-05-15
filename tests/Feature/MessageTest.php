<?php

namespace Tests\Feature;

use App\Models\Messages;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function send_message()
    {
        $user = User::factory()->create(['role' => 'Cliente']);
        $this->actingAs($user);
        $data = [
            'title' => 'Consulta vacunas',
            'subject' => 'Cuando es la próxima vacuna?',
        ];

        $response = $this->post(route('client.contact.send'), $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('messages', [
            'title' => $data['title'],
            'subject' => $data['subject'],
            'id_client' => $user->id,
            'status' => 'No leido',
        ]);
    }

    #[Test]
    public function send_message_fails()
    {
        $user = User::factory()->create(['role' => 'Cliente']);
        $this->actingAs($user);
        $response = $this->post(route('client.contact.send'), []);
        $response->assertSessionHasErrors(['title', 'subject']);
        $this->assertDatabaseCount('messages', 0);
    }

}
