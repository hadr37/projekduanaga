<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;

class ShopTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function shop_page_returns_success(): void
    {
        $response = $this->get('/shop');

        $response->assertStatus(200);
        $response->assertSee('Barang tidak ditemukan.');
    }

    #[Test]
    public function keranjang_page_returns_success(): void
    {   /** @var \App\Models\User $user */
        // buat user dummy dengan role user
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        // login sebagai user dummy
        $this->actingAs($user, 'web');

        // akses halaman keranjang
        $response = $this->get('/keranjang');

        $response->assertStatus(200);
        $response->assertSee('Keranjang Saya');
    }
}
