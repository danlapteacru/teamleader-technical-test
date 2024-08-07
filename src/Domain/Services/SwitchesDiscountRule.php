<?php

namespace App\Domain\Services;

use App\Domain\Entities\Category\CategoryNotFoundException;
use App\Domain\Entities\Order\Order;
use App\Domain\Entities\OrderItem\OrderItem;
use App\Domain\ValueObjects\Discount;
use App\Domain\ValueObjects\Money;

class SwitchesDiscountRule extends AbstractCategoryDiscountRule implements DiscountRule
{
    public static string $description
        = 'For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.';

    /**
     * @throws CategoryNotFoundException
     */
    public function apply(Order $order): ?Discount
    {
        $categoryId = $this->getCategoryIdByName('Switches');

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
        if ($productsTotalQty < 6) {
            return null;
        }

        $discountAmount = 0;
        foreach ($products as $product) {
            $discountAmount += floor($product->getQuantity() / 6) * $product->getUnitPrice();
        }

        return new Discount($this->getDescription(), new Money($discountAmount));
    }
}
