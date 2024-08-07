<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Discount;

use App\Application\Actions\ActionPayload;
use App\Domain\Entities\Customer\Customer;
use App\Domain\Entities\Order\Order;
use App\Domain\Entities\OrderItem\OrderItem;
use App\Domain\Entities\Product\Product;
use App\Domain\Services\ToolsDiscountRule;
use App\Domain\ValueObjects\Discount;
use App\Domain\ValueObjects\Money;
use Tests\TestCase;

class ApplyDiscountActionTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testAction()
    {
        $app = $this->getAppInstance();

        $customer = new Customer(1, 'Coca Cola', '2014-06-28', 492.12);
        $product = new Product('A101', 'Screwdriver', 1, 9.75);
        $orderItem = new OrderItem($product, 2, 9.75, 19.50);

        $discount = new Discount(
            ToolsDiscountRule::$description,
            new Money(3.90),
        );

        $order = new Order(1, $customer, [$orderItem], 19.50);

        $request = $this->createRequest(
            'POST',
            '/order/discounts'
        );
        $request = $request->withParsedBody($order->jsonSerialize());

        $response = $app->handle($request);
        $payload = (string) $response->getBody();

        $expectedPayload = new ActionPayload(200, [$discount->jsonSerialize()]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);
        $this->assertEquals($serializedPayload, $payload);
    }
}
