<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_user_with_hashed_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret123')
        ]);

        $this->assertTrue(Hash::check('secret123', $user->password));
    }

    #[Test]
    public function it_can_update_user_role()
    {
        $user = User::factory()->create(['role' => 'user']);
        $user->role = 'admin';
        $user->save();

        $this->assertEquals('admin', $user->fresh()->role);
    }
}
