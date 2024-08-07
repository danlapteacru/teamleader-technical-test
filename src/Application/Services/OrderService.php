<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Domain\Entities\Category\CategoryRepository;
use App\Domain\Entities\Customer\CustomerNotFoundException;
use App\Domain\Entities\Customer\CustomerRepository;
use App\Domain\Entities\Order\Order;
use App\Domain\Entities\Order\InvalidOrderArgumentException;
use App\Domain\Entities\OrderItem\InvalidOrderItemArgumentException;
use App\Domain\Entities\OrderItem\OrderItem;
use App\Domain\Entities\Product\ProductNotFoundException;
use App\Domain\Entities\Product\ProductRepository;
use App\Domain\Services\DiscountService;

class OrderService
{
    protected DiscountService $discountService;
    protected CategoryRepository $categoryRepository;
    protected CustomerRepository $customerRepository;
    protected ProductRepository $productRepository;

    protected array $orderRequiredFieldsWithTypes = [
        'id' => 'int',
        'customer-id' => 'int',
        'total' => 'float',
        'items' => 'array',
    ];

    protected array $orderItemsRequiredFieldsWithTypes = [
        'product-id' => 'string',
        'quantity' => 'int',
        'unit-price' => 'float',
        'total' => 'float',
    ];

    public function __construct(
        DiscountService $discountService,
        CategoryRepository $categoryRepository,
        CustomerRepository $customerRepository,
        ProductRepository $productRepository,
    ) {
        $this->discountService = $discountService;
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @throws CustomerNotFoundException
     * @throws ProductNotFoundException
     */
    public function getOrderDiscounts(array $orderData): array
    {
        $this->validateOrderData($orderData);
        $orderData = $this->getOrderDataCast($orderData);
        $itemsData = $this->getOrderItemsDataCast($orderData['items']);

        $items = array_map(
            function (array $itemData): OrderItem {
                $product = $this->productRepository->findProductOfId($itemData['product-id']);

                return new OrderItem(
                    $product,
                    $itemData['quantity'],
                    $itemData['unit-price'],
                    $itemData['total']
                );
            },
            $itemsData,
        );

        $customer = $this->customerRepository->findCustomerOfId($orderData['customer-id']);
        $order = new Order($orderData['id'], $customer, $items, $orderData['total']);

        return $this->discountService->calculateDiscount($order);
    }

    protected function castValue(string $type, $value): int|float|array|string|null
    {
        return match ($type) {
            'int' => (int) $value,
            'float' => (float) $value,
            'string' => (string) $value,
            'array' => array_filter((array) $value),
            default => null,
        };
    }

    protected function getOrderDataCast(array $orderData): array
    {
        $castedOrder = [];
        foreach ($this->orderRequiredFieldsWithTypes as $field => $type) {
            $castedOrder[$field] = $this->castValue($type, $orderData[$field]);

            if ($castedOrder[$field] === null) {
                throw new InvalidOrderArgumentException("The order $field must be a valid $type.");
            }
        }

        return $castedOrder;
    }

    protected function getOrderItemsDataCast(array $itemsData): array
    {
        $castedItems = [];
        foreach ($itemsData as $item) {
            foreach ($this->orderItemsRequiredFieldsWithTypes as $field => $type) {
                $item[$field] = $this->castValue($type, $item[$field]);

                if ($item[$field] === null) {
                    throw new InvalidOrderArgumentException("The order item $field must be a valid $type.");
                }
            }
            $castedItems[] = $item;
        }

        return $castedItems;
    }

    public function validateOrderData(array $orderData): void
    {
        $requiredFields = array_keys($this->orderRequiredFieldsWithTypes);
        foreach ($requiredFields as $field) {
            if (! isset($orderData[$field])) {
                throw new InvalidOrderArgumentException("The order must have a $field.");
            }
        }

        $total = (float) $orderData['total'];
        if ($total <= 0) {
            throw new InvalidOrderArgumentException('The order total must be greater than 0.');
        }

        if (! is_array($orderData['items']) || empty($orderData['items'])) {
            throw new InvalidOrderArgumentException('The order must have at least one item.');
        }

        foreach ($orderData['items'] as $item) {
            $this->validateOrderItem($item);
        }
    }

    protected function validateOrderItem(array $item): void
    {
        $requiredFields = array_keys($this->orderItemsRequiredFieldsWithTypes);
        foreach ($requiredFields as $field) {
            if (! isset($item[$field])) {
                throw new InvalidOrderItemArgumentException("The order item must have a $field.");
            }
        }

        if (! is_numeric($item['quantity']) || $item['quantity'] < 0) {
            throw new InvalidOrderItemArgumentException('The order item quantity must be a non-negative number.');
        }

        if (! is_numeric($item['unit-price']) || $item['unit-price'] < 0) {
            throw new InvalidOrderItemArgumentException('The order item unit price must be a non-negative number.');
        }

        if (! is_numeric($item['total']) || $item['total'] < 0) {
            throw new InvalidOrderItemArgumentException('The order item total must be a non-negative number.');
        }
    }
}
