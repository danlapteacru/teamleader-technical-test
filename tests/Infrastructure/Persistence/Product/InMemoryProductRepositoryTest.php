<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Product;

use App\Domain\Entities\Product\Product;
use App\Domain\Entities\Product\ProductNotFoundException;
use App\Infrastructure\Persistence\Product\InMemoryProductRepository;
use Tests\TestCase;

class InMemoryProductRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $product = new Product('A101', 'Screwdriver', 1, 9.75);

        $productRepository = new InMemoryProductRepository([1 => $product]);

        $this->assertEquals([$product], $productRepository->findAll());
    }

    public function testFindAllProductsByDefault()
    {
        $products = [
            1 => new Product('A101', 'Screwdriver', 1, 9.75),
            2 => new Product('A102', 'Electric screwdriver', 1, 49.50),
            3 => new Product('B101', 'Basic on-off switch', 2, 4.99),
            4 => new Product('B102', 'Press button', 2, 4.99),
            5 => new Product('B103', 'Switch with motion detector', 2, 12.95),
        ];

        $productRepository = new InMemoryProductRepository();

        $this->assertEquals(array_values($products), $productRepository->findAll());
    }

    /**
     * @throws ProductNotFoundException
     */
    public function testFindProductOfId()
    {
        $product = new Product('A101', 'Screwdriver', 1, 9.75);

        $productRepository = new InMemoryProductRepository([1 => $product]);

        $this->assertEquals($product, $productRepository->findProductOfId('A101'));
    }

    public function testFindProductOfIdThrowsNotFoundException()
    {
        $productRepository = new InMemoryProductRepository([]);
        $this->expectException(ProductNotFoundException::class);
        $productRepository->findProductOfId('A101');
    }
}
