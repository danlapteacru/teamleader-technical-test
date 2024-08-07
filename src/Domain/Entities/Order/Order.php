<?php

declare(strict_types=1);

namespace App\Domain\Entities\Order;

use App\Domain\Entities\Customer\Customer;
use App\Domain\Entities\OrderItem\OrderItem;
use App\Domain\ValueObjects\Discount;
use App\Domain\ValueObjects\Money;
use JsonSerializable;

class Order implements JsonSerializable
{
    /**
     * @var int The order ID
     */
    protected int $id;

    /**
     * @var Customer The customer who placed the order
     */
    protected Customer $customer;

    /**
     * @var OrderItem[] The items in the order
     */
    protected array $items;

    /**
     * @var float The total of the order
     */
    protected float $total;

    /**
     * @var Discount[] The discounts applied to the order
     */
    protected array $discounts = [];

    public function __construct(int $id, Customer $customer, array $items, float $total)
    {
        $this->id = $id;
        $this->customer = $customer;
        $this->items = $items;
        $this->total = $total;
    }

    /**
     * Get the order ID.
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the customer who placed the order.
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * Get the items in the order.
     * @return OrderItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getRawItems(): array
    {
        return array_map(fn (OrderItem $item): array => $item->jsonSerialize(), $this->items);
    }

    /**
     * Get the total of the order.
     * @return Money
     */
    public function getTotal(): Money
    {
        return new Money($this->total);
    }

    /**
     * Get the discounts applied to the order.
     * @return Discount[]
     */
    public function getDiscounts(): array
    {
        return $this->discounts;
    }

    /**
     * Apply a discount to the order.
     * @param Discount $discount
     */
    public function applyDiscount(Discount $discount): void
    {
        $this->discounts[] = $discount;
        $this->total -= $discount->getAmount()->getAmount();
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'customer-id' => $this->customer->getId(),
            'items' => $this->getRawItems(),
            'total' => $this->total,
        ];
    }
}
