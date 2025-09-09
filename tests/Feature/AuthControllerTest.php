<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shows_login_page()
    {
        $response = $this->get (route('login'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

   #[\PHPUnit\Framework\Attributes\Test]
    public function it_registers_a_user_and_redirects_to_login()
    {
        $response = $this->post(route('register'), [
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'user@test.com',
            'role' => 'user',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_registers_an_admin_and_redirects_to_login()
    {
        $response = $this->post(route('register.admin'), [
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'admin@test.com',
            'role' => 'admin',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_login_and_redirect_to_home()
    {
        $user = User::factory()->create([
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'user@test.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200); // karena return view('home.index')
        $this->assertAuthenticatedAs($user);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function admin_can_login_and_redirect_to_admin_dashboard()
    {
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function login_fails_with_wrong_password()
    {
        User::factory()->create([
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'user@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_logout_and_redirect_home()
    {    /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('logout'));

        $response->assertRedirect(route('home'));
        $this->assertGuest();
    }
}
