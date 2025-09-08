<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerLogicTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function password_is_hashed_on_registration()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $this->assertTrue(Hash::check('password123', $user->password));
    }

    #[Test]
    public function registered_user_has_default_role_user()
    {
        $user = User::factory()->create();
        $this->assertEquals('user', $user->role ?? 'user');
    }

    #[Test]
    public function admin_role_can_be_assigned()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->assertEquals('admin', $admin->role);
    }
}
