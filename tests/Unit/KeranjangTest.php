<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class Keranjang
{
    protected array $items = [];

    public function tambahBarang(int $harga, int $jumlah): void
    {
        $this->items[] = [
            'harga' => $harga,
            'jumlah' => $jumlah,
        ];
    }

    public function hitungTotal(): int
    {
        return array_reduce($this->items, function ($carry, $item) {
            return $carry + ($item['harga'] * $item['jumlah']);
        }, 0);
    }

    public function getItems(): array
    {
        return $this->items;
    }
}

class KeranjangTest extends TestCase
{
    #[Test]
    public function it_calculates_total_correctly(): void
    {
        $keranjang = new Keranjang();
        $keranjang->tambahBarang(10000, 2); // 20000
        $keranjang->tambahBarang(5000, 3);  // 15000

        $this->assertEquals(35000, $keranjang->hitungTotal());
    }

    #[Test]
    public function it_can_add_items_to_cart(): void
    {
        $keranjang = new Keranjang();
        $keranjang->tambahBarang(15000, 1);

        $this->assertCount(1, $keranjang->getItems());
        $this->assertEquals([
            ['harga' => 15000, 'jumlah' => 1]
        ], $keranjang->getItems());
    }
}
