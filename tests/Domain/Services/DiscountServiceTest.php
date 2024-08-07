<?php

declare(strict_types=1);

namespace Tests\Domain\Services;

use App\Domain\Entities\Customer\Customer;
use App\Domain\Entities\Customer\CustomerInvalidSinceDateException;
use App\Domain\Entities\Order\Order;
use App\Domain\Entities\OrderItem\OrderItem;
use App\Domain\Entities\Product\Product;
use App\Domain\Services\DiscountService;
use App\Domain\Services\TotalSpentDiscountRule;
use App\Domain\ValueObjects\Discount;
use App\Domain\ValueObjects\Money;
use Tests\TestCase;

class DiscountServiceTest extends TestCase
{
    /**
     * @throws CustomerInvalidSinceDateException
     */
    public function testCalculateDiscount()
    {
        $discountService = new DiscountService(
            [
                new TotalSpentDiscountRule(),
            ],
        );

        $customer = new Customer(2, 'Teamleader', '2015-01-15', 1505.95);

        $product = new Product('B102', 'Press button', 2, 4.99);

        $orderItems = [
            new OrderItem($product, 5, 4.99, 24.95),
        ];

        $discountToMatch = new Discount(
            TotalSpentDiscountRule::$description,
            new Money(2.50),
        );

        $order = new Order(2, $customer, $orderItems, 24.95);

        $result = $discountService->calculateDiscount($order);

        $this->assertIsArray($result);
        $this->assertEquals([$discountToMatch->jsonSerialize()], $result);
    }
}
