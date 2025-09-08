<?php

namespace Tests\Unit;

use App\Http\Controllers\ProfileController;
use App\Models\AlamatUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_set_default_method_sets_correct_address()
    {  /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $alamat1 = AlamatUser::factory()->create(['user_id' => $user->id, 'is_default' => false]);
        $alamat2 = AlamatUser::factory()->create(['user_id' => $user->id, 'is_default' => false]);

        $this->actingAs($user);

        $controller = new ProfileController();
        $controller->setDefault($alamat1->id);

        $this->assertTrue($alamat1->fresh()->is_default);
        $this->assertFalse($alamat2->fresh()->is_default);
    }
}
