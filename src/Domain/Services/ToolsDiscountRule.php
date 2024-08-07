<?php

namespace App\Domain\Services;

use App\Domain\Entities\Category\CategoryNotFoundException;
use App\Domain\Entities\Order\Order;
use App\Domain\Entities\OrderItem\OrderItem;
use App\Domain\ValueObjects\Discount;
use App\Domain\ValueObjects\Money;

class ToolsDiscountRule extends AbstractCategoryDiscountRule implements DiscountRule
{
    public static string $description
        = 'If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.';

    /**
     * @throws CategoryNotFoundException
     */
    public function apply(Order $order): ?Discount
    {
        $categoryId = $this->getCategoryIdByName('Tools');

        $products = array_filter(
            $order->getItems(),
            // Filter the products that are in the "Tools" category.
            fn (OrderItem $item): bool => $item->getProduct()->getCategoryId() === $categoryId,
        );
        if (empty($products)) {
            return null;
        }

        $productsTotalQty = array_reduce(
            $products,
            // Calculate the total quantity of products in the order with "Tools" category.
            fn (int $totalQty, OrderItem $item): int => $totalQty + $item->getQuantity(),
            0,
        );
        if ($productsTotalQty < 2) {
            return null;
        }

        usort(
            $products,
            fn (OrderItem $a, OrderItem $b): int => $a->getUnitPrice() <=> $b->getUnitPrice(),
        );

        $cheapestToolProduct = reset($products);
        $discountAmount = (new Money($cheapestToolProduct->getUnitPrice()))
            ->multiply(0.2)
            ->multiply($cheapestToolProduct->getQuantity());

        return new Discount($this->getDescription(), $discountAmount);
    }
}
