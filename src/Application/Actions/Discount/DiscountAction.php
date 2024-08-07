<?php

declare(strict_types=1);

namespace App\Application\Actions\Discount;

use App\Application\Actions\Action;
use App\Application\Services\OrderService;
use App\Domain\Entities\Category\CategoryRepository;
use App\Domain\Entities\Customer\CustomerRepository;
use App\Domain\Entities\Product\ProductRepository;
use Psr\Log\LoggerInterface;

abstract class DiscountAction extends Action
{
    protected CategoryRepository $categoryRepository;
    protected CustomerRepository $customerRepository;
    protected OrderService $orderService;
    protected ProductRepository $productRepository;

    public function __construct(
        LoggerInterface $logger,
        CategoryRepository $categoryRepository,
        CustomerRepository $customerRepository,
        OrderService $orderService,
        ProductRepository $productRepository,
    ) {
        parent::__construct($logger);
        $this->categoryRepository = $categoryRepository;
        $this->customerRepository = $customerRepository;
        $this->orderService = $orderService;
        $this->productRepository = $productRepository;
    }
}
