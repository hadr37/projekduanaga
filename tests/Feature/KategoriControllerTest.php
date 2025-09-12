<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kategori;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class KategoriControllerTest extends TestCase
{   
    use RefreshDatabase;
     
    protected function actingAsAdmin()
    {   /** @var \App\Models\User $admin */
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        return $admin;
    }

    #[Test]
    public function index_page_shows_for_admin()
    {
        $this->actingAsAdmin();

        $response = $this->get(route('admin.kategori.index'));

        $response->assertStatus(200);
        $response->assertSee('Data Kategori');
    }

    #[Test]
    public function admin_can_store_kategori()
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.kategori.store'), [
            'nama_kategori' => 'Elektronik',
            'deskripsi' => 'Kategori elektronik',
            'gambar' => UploadedFile::fake()->create('kategori.jpg', 200), // fake file, tidak pakai GD
        ]);

        $response->assertRedirect(route('admin.kategori.index'));
        $this->assertDatabaseHas('kategoris', ['nama_kategori' => 'Elektronik']);
    }

    #[Test]
    public function admin_can_update_kategori()
    {
        $this->actingAsAdmin();

        $kategori = Kategori::create([
            'nama_kategori' => 'Fashion',
            'deskripsi' => '-',
        ]);

        $response = $this->put(route('admin.kategori.update', $kategori->id), [
            'nama_kategori' => 'Fashion Baru',
            'deskripsi' => 'Update deskripsi',
        ]);

        $response->assertRedirect(route('admin.kategori.index'));
        $this->assertDatabaseHas('kategoris', ['nama_kategori' => 'Fashion Baru']);
    }

    #[Test]
    public function admin_can_delete_kategori()
    {
        $this->actingAsAdmin();

        $kategori = Kategori::create([
            'nama_kategori' => 'Hapus Saya',
            'deskripsi' => '-',
        ]);

        $response = $this->delete(route('admin.kategori.destroy', $kategori->id));

        $response->assertRedirect(route('admin.kategori.index'));
        $this->assertDatabaseMissing('kategoris', ['nama_kategori' => 'Hapus Saya']);
    }

    #[Test]
public function admin_can_search_kategori()
{
    $this->actingAsAdmin();

    Kategori::create(['nama_kategori' => 'Elektronik', 'deskripsi' => '-']);
    Kategori::create(['nama_kategori' => 'Fashion', 'deskripsi' => '-']);

    $response = $this->get(route('admin.kategori.index', ['search' => 'Elektronik']));

    $response->assertStatus(200);
    $response->assertSee('Elektronik');


}

}
