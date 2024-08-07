<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Order\Order;
use App\Domain\ValueObjects\Discount;

class DiscountService
{
    /**
     * @var DiscountRule[] The discount rules
     */
    protected array $discountRules;

    public function __construct(array $discountRules)
    {
        $this->discountRules = $discountRules;
    }

    /**
     * Calculate the discount for the order
     *
     * @param Order $order The order
     *
     * @return array The discounts
     */
    public function calculateDiscount(Order $order): array
    {
        foreach ($this->discountRules as $rule) {
            $discount = $rule->apply($order);
            if ($discount === null) {
                continue;
            }

            $order->applyDiscount($discount);
        }

        return array_map(
            fn (Discount $discount): array => [
                'reason' => $discount->getReason(),
                'amount' => (string) $discount->getAmount(),
            ],
            $order->getDiscounts(),
        );
    }
}
