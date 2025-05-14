<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test crear usuario cliente
     *
     * @return void
     */
    public function test_user_registration()
    {
        $this->refreshDatabase(); 

        $data = [
            'name' => 'Carlos',
            'surname' => 'Fez',
            'email' => 'carlos.feze@example.com',
            'dni' => '12345678A',
            'phone' => '666666666',
            'address' => 'Calle Marina',
            'city' => 'Barcelona',
            'country' => 'España',
            'postcode' => '08028',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $response = $this->post(route('register.post'), $data);
        $response->assertRedirect(route('client.dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'carlos.feze@example.com',
            'role' => 'Cliente',
        ]);
        $user = User::where('email', 'carlos.feze@example.com')->first();
        $this->assertTrue(Hash::check('Password123', $user->password));
    }

    /**
     * Test login cliente
     *
     * @return void
     */
    public function test_user_login()
    {
        $user = User::create([
            'name' => 'Carla',
            'surname' => 'Sanz',
            'email' => 'carla.sanz@example.com',
            'dni' => '87654321B',
            'phone' => '666554433',
            'address' => 'Calle Monte',
            'city' => 'Madrid',
            'country' => 'España',
            'postcode' => '28028',
            'password' => bcrypt('Password123'),
            'role' => 'Cliente',
        ]);

        $response = $this->post(route('login.post'), [
            'email' => $user->email,
            'password' => 'Password123',
        ]);
        $response->assertRedirect(route('client.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test login usuario credenciales incorrectas
     *
     * @return void
     */
    public function test_user_login_invalid_credentials()
    {
        $response = $this->post(route('login.post'), [
            'email' => 'email@example.com',
            'password' => 'wrongPass',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /**
     * Test logout cliente
     *
     * @return void
     */
    public function test_user_logout()
    {
        $user = User::create([
            'name' => 'Sandra',
            'surname' => 'Berneda',
            'email' => 'sandra@example.com',
            'dni' => '12121212A',
            'phone' => '666998877',
            'address' => 'Calle Rio',
            'city' => 'Barcelona',
            'country' => 'España',
            'postcode' => '08028',
            'password' => bcrypt('Password123'),
            'role' => 'Cliente',
        ]);
        $this->actingAs($user);
        $response = $this->get(route('logout'));
        Auth::logout();
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
