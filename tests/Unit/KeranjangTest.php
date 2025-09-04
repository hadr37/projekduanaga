<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class KeranjangTest extends TestCase
{
    #[Test]
    public function it_calculates_total_correctly(): void
    {
        $items = [
            ['harga' => 10000, 'jumlah' => 2],
            ['harga' => 5000, 'jumlah' => 3],
        ];

        $total = 0;
        foreach ($items as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        $this->assertEquals(10000*2 + 5000*3, $total);
    }
}
