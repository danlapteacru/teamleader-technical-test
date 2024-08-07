<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Product;

use App\Domain\Entities\Product\Product;
use App\Domain\Entities\Product\ProductNotFoundException;
use App\Domain\Entities\Product\ProductRepository;

class InMemoryProductRepository implements ProductRepository
{
    /**
     * @var Product[]
     */
    protected array $products;

    /**
     * @param Product[]|null $products
     */
    public function __construct(array $products = null)
    {
        $this->products = $products ?? [
            1 => new Product('A101', 'Screwdriver', 1, 9.75),
            2 => new Product('A102', 'Electric screwdriver', 1, 49.50),
            3 => new Product('B101', 'Basic on-off switch', 2, 4.99),
            4 => new Product('B102', 'Press button', 2, 4.99),
            5 => new Product('B103', 'Switch with motion detector', 2, 12.95),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->products);
    }

    /**
     * {@inheritdoc}
     */
    public function findProductOfId(string $id): Product
    {
        foreach ($this->products as $product) {
            if ($product->getId() === $id) {
                return $product;
            }
        }

        throw new ProductNotFoundException();
    }
}
