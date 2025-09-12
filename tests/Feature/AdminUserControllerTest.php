<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminUserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // login sebagai admin
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    #[Test]
    public function it_shows_user_index_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
        $response->assertSee($user->name);
    }

    #[Test]
    public function it_can_store_user()
    {
        $data = [
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'user',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.store'), $data);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['email' => 'user@test.com']);
    }

    #[Test]
    public function it_can_update_user_without_password_change()
    {
        $user = User::factory()->create();

        $updateData = [
            'name' => 'Updated User',
            'email' => $user->email,
            'role' => $user->role,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.users.update', $user), $updateData);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated User']);
    }

    #[Test]
    public function it_can_update_user_with_password_change()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpass')]);

        $updateData = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'old_password' => 'oldpass',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.users.update', $user), $updateData);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }

    #[Test]
    public function it_fails_update_if_old_password_wrong()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpass')]);

        $updateData = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'old_password' => 'wrongpass',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.users.update', $user), $updateData);

        $response->assertSessionHasErrors(['old_password']);
        $this->assertTrue(Hash::check('oldpass', $user->fresh()->password));
    }

    #[Test]
    public function it_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.users.destroy', $user));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
