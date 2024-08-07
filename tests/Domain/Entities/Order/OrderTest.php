<?php

declare(strict_types=1);

namespace Tests\Domain\Entities\Order;

use App\Domain\Entities\Customer\Customer;
use App\Domain\Entities\Customer\CustomerInvalidSinceDateException;
use App\Domain\Entities\Order\Order;
use App\Domain\Entities\OrderItem\OrderItem;
use App\Domain\Entities\Product\Product;
use App\Domain\ValueObjects\Discount;
use App\Domain\ValueObjects\Money;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * @throws CustomerInvalidSinceDateException
     */
    public function orderItemProvider(): array
    {
        $customer = new Customer(1, 'Coca Cola', '2014-06-28', 492.12);
        $product = new Product('A101', 'Screwdriver', 1, 9.75);
        $orderItem = new OrderItem($product, 2, 9.75, 19.50);

        return [
            [1, $customer, [$orderItem], 19.50],
            [2, $customer, [$orderItem, $orderItem], 39.00],
            [3, $customer, [$orderItem, $orderItem, $orderItem], 58.50],
        ];
    }

    /**
     * @dataProvider orderItemProvider
     * @param int $id
     * @param Customer $customer
     * @param array $items
     * @param float $total
     */
    public function testGetters(int $id, Customer $customer, array $items, float $total): void
    {
        $order = new Order($id, $customer, $items, $total);

        $this->assertEquals($id, $order->getId());
        $this->assertEquals($customer, $order->getCustomer());
        $this->assertEquals($items, $order->getItems());
        $this->assertEquals($total, $order->getTotal()->getAmount());
    }

    /**
     * @dataProvider orderItemProvider
     * @param int $id
     * @param Customer $customer
     * @param array $items
     * @param float $total
     */
    public function testDiscounts(int $id, Customer $customer, array $items, float $total): void
    {
        $order = new Order($id, $customer, $items, $total);
        $discount = new Discount('10% off', (new Money($total))->multiply(0.10));
        $order->applyDiscount($discount);

        $this->assertEquals($total - ($total * 0.10), $order->getTotal()->getAmount());
        $this->assertEquals([$discount], $order->getDiscounts());
    }

    /**
     * @dataProvider orderItemProvider
     * @param int $id
     * @param Customer $customer
     * @param array $items
     * @param float $total
     */
    public function testJsonSerialize(int $id, Customer $customer, array $items, float $total): void
    {
        $order = new Order($id, $customer, $items, $total);

        $expectedPayload = json_encode([
            'id' => $id,
            'customer-id' => $customer->getId(),
            'items' => $items,
            'total' => $total,
        ]);

        $this->assertEquals($expectedPayload, json_encode($order));
    }
}
