<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopTest extends TestCase
{
    /**
     * Test halaman shop bisa diakses.
     */
    public function test_shop_page_returns_success(): void
    {
        $response = $this->get('/shop');

        $response->assertStatus(200); // Pastikan HTTP status = 200 OK
        $response->assertSee('Shop'); // Pastikan ada teks "Shop" di halaman
    }

    /**
     * Test halaman keranjang bisa diakses.
     */
    public function test_keranjang_page_returns_success(): void
    {
        $response = $this->get('/keranjang');

        $response->assertStatus(200); 
        $response->assertSee('Keranjang'); // pastikan ada tulisan "Keranjang"
    }
}
