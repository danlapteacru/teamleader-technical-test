<?php

declare(strict_types=1);

namespace Tests\Application\Services;

use App\Application\Services\OrderService;
use App\Domain\Entities\Category\CategoryRepository;
use App\Domain\Entities\Customer\CustomerNotFoundException;
use App\Domain\Entities\Customer\CustomerRepository;
use App\Domain\Entities\Order\InvalidOrderArgumentException;
use App\Domain\Entities\OrderItem\InvalidOrderItemArgumentException;
use App\Domain\Entities\Product\ProductNotFoundException;
use App\Domain\Entities\Product\ProductRepository;
use App\Domain\Services\DiscountService;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    protected DiscountService $discountService;
    protected CustomerRepository $customerRepository;
    protected ProductRepository $productRepository;
    protected OrderService $orderService;

    protected function setUp(): void
    {
        $this->discountService = $this->createMock(DiscountService::class);
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $this->customerRepository = $this->createMock(CustomerRepository::class);
        $this->productRepository = $this->createMock(ProductRepository::class);

        $this->orderService = new OrderService(
            $this->discountService,
            $categoryRepository,
            $this->customerRepository,
            $this->productRepository
        );
    }

    /**
     * @throws CustomerNotFoundException
     * @throws ProductNotFoundException
     */
    public function testGetOrderDiscounts()
    {
        $orderData = [
            'id' => 3,
            'customer-id' => 3,
            'total' => 69.00,
            'items' => [
                [
                    'product-id' => 'A101',
                    'quantity' => 2,
                    'unit-price' => 9.75,
                    'total' => 19.50,
                ],
                [
                    'product-id' => 'A102',
                    'quantity' => 1,
                    'unit-price' => 49.50,
                    'total' => 49.50,
                ],
            ],
        ];

        $discounts = $this->orderService->getOrderDiscounts($orderData);
        $this->assertIsArray($discounts);
    }

    public function testValidateOrderData()
    {
        $orderData = [
            'id' => 3,
            'customer-id' => 3,
            'total' => 69.00,
            'items' => [
                [
                    'product-id' => 'A101',
                    'quantity' => 2,
                    'unit-price' => 9.75,
                    'total' => 19.50,
                ],
                [
                    'product-id' => 'A102',
                    'quantity' => 1,
                    'unit-price' => 49.50,
                    'total' => 49.50,
                ],
            ],
        ];

        $this->orderService->validateOrderData($orderData);
        $this->assertIsBool(true);
    }

    public function testValidateOrderDataInvalidOrderArgumentException()
    {
        $orderData = [
            'id' => 1,
            'total' => 19.50,
            'items' => [
                [
                    'product-id' => 'A101',
                    'quantity' => 2,
                    'unit-price' => 9.75,
                    'total' => 19.50,
                ],
            ],
        ];

        $this->expectException(InvalidOrderArgumentException::class);
        $this->orderService->validateOrderData($orderData);
    }

    public function testValidateOrderDataInvalidOrderItemArgumentException()
    {
        $orderData = [
            'id' => 1,
            'customer-id' => 1,
            'total' => 19.50,
            'items' => [
                [
                    'quantity' => 2,
                    'unit-price' => 9.75,
                    'total' => 19.50,
                ],
            ],
        ];

        $this->expectException(InvalidOrderItemArgumentException::class);
        $this->orderService->validateOrderData($orderData);
    }
}
