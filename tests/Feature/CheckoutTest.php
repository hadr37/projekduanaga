<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Barang;
use App\Models\Card;
use App\Models\Pesanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $barang;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->barang = Barang::factory()->create([
            'stok' => 10,
            'harga' => 50000,
        ]);
        Card::create([
            'user_id'    => $this->user->id,
            'product_id' => $this->barang->id,
            'jumlah'     => 2,
        ]);
    }

    #[Test]
    public function checkout_page_shows_for_logged_in_user(): void
    {
        $response = $this->actingAs($this->user)->get(route('katalog.checkout'));
        $response->assertStatus(200);
    }

    #[Test]
    public function user_can_checkout_with_manual_transfer(): void
    {
        $response = $this->actingAs($this->user)->post(route('katalog.checkout.proses'), [
            'jenis_pembayaran' => 'manual_transfer',
            'bank'             => 'BCA',
            'nama_rekening'    => 'User Transfer',
            'no_rekening'      => '1234567890',
        ]);

        $response->assertRedirect(route('katalog.pesanan'));
        $this->assertDatabaseHas('pesanan', [
            'user_id'          => $this->user->id,
            'jenis_pembayaran' => 'manual_transfer',
            'status'           => 'pemrosesan',
        ]);
    }

    #[Test]
    public function user_can_checkout_with_virtual_account_and_auto_generate_no_rekening(): void
    {
        $response = $this->actingAs($this->user)->post(route('katalog.checkout.proses'), [
            'jenis_pembayaran' => 'virtual_account',
            'bank'             => 'BNI',
            'nama_rekening'    => 'User VA',
        ]);

        $response->assertRedirect(route('katalog.pesanan'));

        $pesanan = Pesanan::first();
        $this->assertEquals('virtual_account', $pesanan->jenis_pembayaran);
        $this->assertStringStartsWith('VA', $pesanan->no_rekening);
    }

    #[Test]
    public function checkout_fails_with_insufficient_stock(): void
    {
        $this->barang->update(['stok' => 1]);

        $response = $this->actingAs($this->user)->post(route('katalog.checkout.proses'), [
            'jenis_pembayaran' => 'manual_transfer',
            'bank'             => 'BCA',
            'nama_rekening'    => 'User Transfer',
            'no_rekening'      => '0987654321',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('pesanan', [
            'user_id' => $this->user->id,
        ]);
    }
}
