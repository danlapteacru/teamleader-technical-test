<?php

declare(strict_types=1);

namespace App\Domain\Entities\Product;

interface ProductRepository
{
    /**
     * @return Product[]
     */
    public function findAll(): array;

    /**
     * @param string $id
     * @return Product
     * @throws ProductNotFoundException
     */
    public function findProductOfId(string $id): Product;
}
