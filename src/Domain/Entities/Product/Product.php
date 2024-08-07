<?php

declare(strict_types=1);

namespace App\Domain\Entities\Product;

use JsonSerializable;

class Product implements JsonSerializable
{
    /**
     * Product ID.
     * @var string $id
     */
    protected string $id;

    /**
     * Product description.
     * @var string $description
     */
    protected string $description;

    /**
     * Category ID.
     * @var int $categoryId
     */
    protected int $categoryId;

    /**
     * Product unit price.
     * @var float $price
     */
    protected float $price;

    public function __construct(string $id, string $description, int $categoryId, float $price)
    {
        $this->id = $id;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->price = $price;
    }

    /**
     * Get the product ID.
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the product description.
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get the category ID.
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * Get the product price.
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'category' => $this->categoryId,
            'price' => $this->price,
        ];
    }
}
