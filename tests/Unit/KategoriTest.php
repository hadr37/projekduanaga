<?php

namespace Tests\Unit;

use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class KategoriTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_kategori()
    {
        $kategori = Kategori::factory()->create([
            'nama_kategori' => 'Kosmetik',
            'deskripsi' => 'Produk perawatan kecantikan',
        ]);

        // harus cek ke tabel 'kategoris', bukan 'kategori'
        $this->assertDatabaseHas('kategoris', [
            'id' => $kategori->id,
            'nama_kategori' => 'Kosmetik',
        ]);
    }

    #[Test]
    public function it_requires_nama_kategori()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Kategori::create([]); // tanpa nama -> gagal
    }

    #[Test]
    public function it_can_update_kategori()
    {
        $kategori = Kategori::factory()->create(['nama_kategori' => 'Lama']);

        $kategori->update(['nama_kategori' => 'Baru']);

        $this->assertEquals('Baru', $kategori->fresh()->nama_kategori);
    }
}
