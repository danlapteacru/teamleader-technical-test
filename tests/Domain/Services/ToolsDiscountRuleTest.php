<?php

declare(strict_types=1);

namespace Tests\Domain\Services;

use App\Domain\Entities\Category\Category;
use App\Domain\Entities\Category\CategoryNotFoundException;
use App\Domain\Entities\Customer\Customer;
use App\Domain\Entities\Customer\CustomerInvalidSinceDateException;
use App\Domain\Entities\Order\Order;
use App\Domain\Entities\OrderItem\OrderItem;
use App\Domain\Entities\Product\Product;
use App\Domain\Services\ToolsDiscountRule;
use App\Domain\ValueObjects\Discount;
use App\Domain\ValueObjects\Money;
use App\Infrastructure\Persistence\Category\InMemoryCategoryRepository;
use Tests\TestCase;

class ToolsDiscountRuleTest extends TestCase
{
    /**
     * @throws CategoryNotFoundException
     * @throws CustomerInvalidSinceDateException
     */
    public function testApply()
    {
        $category = new Category(1, 'Tools');
        $categoryRepository = new InMemoryCategoryRepository([1 => $category]);
        $toolsDiscountRule = new ToolsDiscountRule($categoryRepository);

        $customer = new Customer(3, 'Jeroen De Wit', '2016-02-11');

        $product1 = new Product('A101', 'Screwdriver', 1, 9.75);
        $product2 = new Product('A102', 'Electric screwdriver', 1, 49.50);

        $orderItems = [
            new OrderItem($product1, 2, 9.75, 19.50),
            new OrderItem($product2, 1, 49.50, 49.90),
        ];

        $discountToMatch = new Discount(
            ToolsDiscountRule::$description,
            new Money(3.90),
        );

        $order = new Order(3, $customer, $orderItems, 69.00);

        $discount = $toolsDiscountRule->apply($order);

        $this->assertInstanceOf(Discount::class, $discount);
        $this->assertEquals((string) $discountToMatch, (string) $discount);
    }
}
