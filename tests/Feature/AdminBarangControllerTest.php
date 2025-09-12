<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminBarangControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Kategori $kategori;

    protected function setUp(): void
    {
        parent::setUp();

        // buat user login
        $this->admin = User::factory()->create();
        $this->kategori = Kategori::factory()->create();
    }

    #[Test]
    public function it_shows_barang_index_page()
    {
        $barang = Barang::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.barang.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.barang.index');
        $response->assertSee($barang->nama_barang);
    }

    #[Test]
    public function it_can_store_barang()
    {
        Storage::fake('public');

        $data = [
            'kode_barang' => 'BRG001',
            'nama_barang' => 'Test Barang',
            'kategori_id' => $this->kategori->id,
            'deskripsi'   => 'Barang untuk test',
            'harga'       => 5000,
            'stok'        => 10,
            'gambar'      => UploadedFile::fake()->create('barang.jpg', 100, 'image/jpeg'),

        ];

        $response = $this->actingAs($this->admin)->post(route('admin.barang.store'), $data);

        $response->assertRedirect(route('admin.barang.index'));
        $this->assertDatabaseHas('barangs', ['nama_barang' => 'Test Barang']);
    }

    #[Test]
    public function it_can_update_barang()
    {
        $barang = Barang::factory()->create(['kategori_id' => $this->kategori->id]);

        $updateData = [
            'kode_barang' => $barang->kode_barang,
            'nama_barang' => 'Barang Updated',
            'kategori_id' => $this->kategori->id,
            'harga'       => 8000,
            'stok'        => 15,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.barang.update', $barang), $updateData);

        $response->assertRedirect(route('admin.barang.index'));
        $this->assertDatabaseHas('barangs', ['nama_barang' => 'Barang Updated']);
    }

    #[Test]
    public function it_can_delete_barang()
    {
        $barang = Barang::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.barang.destroy', $barang));

        $response->assertRedirect(route('admin.barang.index'));
        $this->assertDatabaseMissing('barangs', ['id' => $barang->id]);
    }
}
