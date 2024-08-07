<?php

declare(strict_types=1);

namespace Tests\Domain\Entities\OrderItem;

use App\Domain\Entities\OrderItem\OrderItem;
use App\Domain\Entities\Product\Product;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    public function orderItemProvider(): array
    {
        $product = new Product('A101', 'Screwdriver', 1, 9.75);

        return [
            [$product, 2, 9.75, 19.50],
        ];
    }

    /**
     * @dataProvider orderItemProvider
     * @param Product $product
     * @param int $quantity
     * @param float $unitPrice
     * @param float $total
     */
    public function testGetters(Product $product, int $quantity, float $unitPrice, float $total): void
    {
        $orderItem = new OrderItem($product, $quantity, $unitPrice, $total);

        $this->assertEquals($product, $orderItem->getProduct());
        $this->assertEquals($product->getId(), $orderItem->getProductId());
        $this->assertEquals($quantity, $orderItem->getQuantity());
        $this->assertEquals($unitPrice, $orderItem->getUnitPrice());
        $this->assertEquals($total, $orderItem->getTotal());
    }

    /**
     * @dataProvider orderItemProvider
     * @param Product $product
     * @param int $quantity
     * @param float $unitPrice
     * @param float $total
     */
    public function testJsonSerialize(Product $product, int $quantity, float $unitPrice, float $total): void
    {
        $orderItem = new OrderItem($product, $quantity, $unitPrice, $total);

        $expectedPayload = json_encode([
            'product-id' => $product->getId(),
            'quantity' => $quantity,
            'unit-price' => $unitPrice,
            'total' => $total,
        ]);

        $this->assertEquals($expectedPayload, json_encode($orderItem));
    }
}
