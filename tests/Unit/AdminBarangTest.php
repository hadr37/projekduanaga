<?php

namespace Tests\Unit;

use App\Models\Barang;
use App\Models\Kategori;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBarangTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function barang_belongs_to_kategori()
    {
        $kategori = Kategori::factory()->create();
        $barang = Barang::factory()->create(['kategori_id' => $kategori->id]);

        $this->assertEquals($kategori->id, $barang->kategori->id);
    }

    #[Test]
    public function it_can_calculate_total_stok()
    {
        Barang::factory()->create(['stok' => 5]);
        Barang::factory()->create(['stok' => 10]);

        $this->assertEquals(15, Barang::sum('stok'));
    }
}
