<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\AlamatUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_profile_routes()
    {
        $response = $this->get(route('profile.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_addresses()
    {    /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('profile.index'))
            ->assertStatus(200);
    }

    public function test_user_can_create_address()
    {
        $user = User::factory()->create();

        $data = [
            'namapenerima' => 'Haidar',
            'no_telepon'   => '08123456789',
            'alamat'       => 'Jl. Merdeka 123',
            'is_default'   => true,
        ];
         /** @var \App\Models\User $user */
        $this->actingAs($user)
            ->post(route('profile.store'), $data)
            ->assertRedirect(route('profile.index'));

        $this->assertDatabaseHas('alamat_users', [
            'namapenerima' => 'Haidar',
            'is_default'   => true,
        ]);
    }

    public function test_user_can_update_address()
    {
        $user = User::factory()->create();
        $alamat = AlamatUser::factory()->create(['user_id' => $user->id]);

        $update = [
            'namapenerima' => 'Updated Name',
            'no_telepon'   => '081298765432',
            'alamat'       => 'Jl. Update 456',
            'is_default'   => true,
        ];
            /** @var \App\Models\User $user */
        $this->actingAs($user)
            ->put(route('profile.update', $alamat->id), $update)
            ->assertRedirect(route('profile.index'));

        $this->assertDatabaseHas('alamat_users', $update);
    }

    public function test_user_can_delete_address()
    {    /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $alamat = AlamatUser::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->delete(route('profile.destroy', $alamat->id))
            ->assertRedirect(route('profile.index'));

        $this->assertDatabaseMissing('alamat_users', ['id' => $alamat->id]);
    }

  
    public function user_can_set_default_address()
    {   /** @var \App\Models\User $user */
        $user = User::factory()->create(['role' => 'user']);
        $alamat1 = AlamatUser::factory()->create(['user_id' => $user->id, 'is_default' => false]);
        $alamat2 = AlamatUser::factory()->create(['user_id' => $user->id, 'is_default' => false]);

        $this->actingAs($user)
            ->post(route('profile.setDefault', $alamat1->id))
            ->assertRedirect(route('profile.index'));

        $this->assertTrue($alamat1->fresh()->is_default);
        $this->assertFalse($alamat2->fresh()->is_default);
    }
}
