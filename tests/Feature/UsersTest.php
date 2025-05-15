<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function client_show_profile()
    {
        $user = User::factory()->create(['role' => 'Cliente']);
        $this->actingAs($user)
            ->get(route('client.showClient'))
            ->assertOk()
            ->assertViewIs('client.showClient')
            ->assertViewHas('user');
    }

    #[Test]
    public function veterinary_show_profile()
    {
        $user = User::factory()->create(['role' => 'Veterinario']);
        $this->actingAs($user)
            ->get(route('veterinary.showProfile'))
            ->assertOk()
            ->assertViewIs('veterinary.showProfile')
            ->assertViewHas('user');
    }

    #[Test]
    public function client_edit_profile()
    {
        $user = User::factory()->create(['role' => 'Cliente']);
        $data = [
            'name' => 'sara',
            'surname' => 'garcia',
            'email' => 'sara@example.com',
            'phone' => '666777888',
            'address' => 'Calle luna',
            'city' => 'devilla',
            'country' => 'rspaña',
            'postcode' => '41001',
        ];

        $this->actingAs($user)
            ->put(route('client.updateClient'), $data)
            ->assertRedirect(route('client.showClient'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'sara@example.com',
        ]);
    }

    #[Test]
    public function veterinary_edit_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('oldpassword'),
            'role' => 'Veterinario',
        ]);
        $response = $this->actingAs($user)
            ->put(route('veterinary.updatePassword'), [
                'current_password' => 'oldpassword',
                'new_password' => 'newpassword123',
                'new_password_confirmation' => 'newpassword123',
            ]);
        $response->assertRedirect()
            ->assertSessionHas('success');
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }

    #[Test]
    public function user_cant_edit_password_actual_wrong()
    {
        $user = User::factory()->create([
            'password' => bcrypt('oldpassword'),
            'role' => 'Veterinario',
        ]);
        $response = $this->actingAs($user)
            ->put(route('veterinary.updatePassword'), [
                'current_password' => 'wrongpassword',
                'new_password' => 'newpassword123',
                'new_password_confirmation' => 'newpassword123',
            ]);
        $response->assertSessionHasErrors('current_password');
        $this->assertFalse(Hash::check('newpassword123', $user->fresh()->password));
    }
}