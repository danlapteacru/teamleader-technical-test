<?php

declare(strict_types=1);

namespace App\Domain\Entities\OrderItem;

use App\Domain\Entities\Product\Product;
use JsonSerializable;

class OrderItem implements JsonSerializable
{
    /**
     * @var Product $product
     */
    protected Product $product;

    /**
     * @var int $quantity
     */
    protected int $quantity;

    /**
     * @var float $unitPrice
     */
    protected float $unitPrice;

    /**
     * @var float $total
     */
    protected float $total;

    public function __construct(Product $product, int $quantity, float $unitPrice, float $total)
    {
        $this->product = $product;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->total = $total;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getProductId(): string
    {
        return $this->product->getId();
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'product-id' => $this->getProductId(),
            'quantity' => $this->quantity,
            'unit-price' => $this->unitPrice,
            'total' => $this->total,
        ];
    }
}
