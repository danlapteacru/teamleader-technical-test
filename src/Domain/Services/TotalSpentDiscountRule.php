<?php

namespace App\Domain\Services;

use App\Domain\Entities\Order\Order;
use App\Domain\ValueObjects\Discount;
use App\Domain\ValueObjects\Money;

class TotalSpentDiscountRule extends AbstractDiscountRule implements DiscountRule
{
    public static string $description
        = 'A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.';

    public function apply(Order $order): ?Discount
    {
        $customer = $order->getCustomer();
        $revenue = $customer->getRevenue();

        $amount = new Money(1000);

        if ($revenue->isGreaterThanOrEqual($amount)) {
            return new Discount(
                $this->getDescription(),
                $order->getTotal()->multiply(0.10),
            );
        }

        return null;
    }
}
