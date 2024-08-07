<?php

declare(strict_types=1);

namespace Tests\Domain\Entities\Product;

use App\Domain\Entities\Product\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function productProvider(): array
    {
        return [
            ['A101', 'Screwdriver', 1, 9.75],
            ['A102', 'Electric screwdriver', 1, 49.50],
            ['B101', 'Basic on-off switch', 2, 4.99],
            ['B102', 'Press button', 2, 4.99],
            ['B103', 'Switch with motion detector', 2, 12.95],
        ];
    }

    /**
     * @dataProvider productProvider
     * @param string $id
     * @param string $description
     * @param int $categoryId
     * @param float $price
     */
    public function testGetters(string $id, string $description, int $categoryId, float $price): void
    {
        $product = new Product($id, $description, $categoryId, $price);

        $this->assertEquals($id, $product->getId());
        $this->assertEquals($description, $product->getDescription());
        $this->assertEquals($categoryId, $product->getCategoryId());
        $this->assertEquals($price, $product->getPrice());
    }

    /**
     * @dataProvider productProvider
     * @param string $id
     * @param string $description
     * @param int $categoryId
     * @param float $price
     */
    public function testJsonSerialize(string $id, string $description, int $categoryId, float $price): void
    {
        $product = new Product($id, $description, $categoryId, $price);

        $expectedPayload = json_encode([
            'id' => $id,
            'description' => $description,
            'category' => $categoryId,
            'price' => $price,
        ]);

        $this->assertEquals($expectedPayload, json_encode($product));
    }
}
