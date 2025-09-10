<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CheckoutLogicTest extends TestCase
{
    #[Test]
    public function it_calculates_total_correctly(): void
    {
        $items = [
            ['harga' => 10000, 'jumlah' => 2],
            ['harga' => 5000, 'jumlah' => 3],
        ];

        $total = array_sum(array_map(fn($i) => $i['harga'] * $i['jumlah'], $items));

        $this->assertEquals(10000*2 + 5000*3, $total);
    }

    #[Test]
    public function it_generates_virtual_account_number_correctly(): void
    {
        $pesananId = 12;
        $noVA = "VA" . str_pad($pesananId, 6, "0", STR_PAD_LEFT);

        $this->assertEquals("VA000012", $noVA);
        $this->assertStringStartsWith("VA", $noVA);
        $this->assertEquals(8, strlen($noVA));
    }
}
