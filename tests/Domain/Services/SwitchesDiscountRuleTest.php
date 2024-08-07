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
use App\Domain\Services\SwitchesDiscountRule;
use App\Domain\ValueObjects\Discount;
use App\Domain\ValueObjects\Money;
use App\Infrastructure\Persistence\Category\InMemoryCategoryRepository;
use Tests\TestCase;

class SwitchesDiscountRuleTest extends TestCase
{
    /**
     * @throws CategoryNotFoundException
     * @throws CustomerInvalidSinceDateException
     */
    public function testApply()
    {
        $category = new Category(2, 'Switches');
        $categoryRepository = new InMemoryCategoryRepository([2 => $category]);
        $switchesDiscountRule = new SwitchesDiscountRule($categoryRepository);

        $customer = new Customer(1, 'Coca Cola', '2014-06-28', 492.12);
        $product = new Product('B102', 'Press button', 2, 4.99);
        $orderItem = new OrderItem($product, 10, 4.99, 49.90);

        $discountToMatch = new Discount(
            SwitchesDiscountRule::$description,
            new Money(4.99),
        );

        $order = new Order(1, $customer, [$orderItem], 19.50);

        $discount = $switchesDiscountRule->apply($order);

        $this->assertInstanceOf(Discount::class, $discount);
        $this->assertEquals((string) $discountToMatch, (string) $discount);
    }
}
