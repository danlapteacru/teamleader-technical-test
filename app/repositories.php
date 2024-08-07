<?php

declare(strict_types=1);

use App\Application\Services\OrderService;
use App\Domain\Entities\Category\CategoryRepository;
use App\Domain\Entities\Customer\CustomerRepository;
use App\Domain\Entities\Product\ProductRepository;
use App\Domain\Services\DiscountService;
use App\Domain\Services\SwitchesDiscountRule;
use App\Domain\Services\ToolsDiscountRule;
use App\Domain\Services\TotalSpentDiscountRule;
use App\Infrastructure\Persistence\Category\InMemoryCategoryRepository;
use App\Infrastructure\Persistence\Customer\InMemoryCustomerRepository;
use App\Infrastructure\Persistence\Product\InMemoryProductRepository;
use DI\ContainerBuilder;

use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        CategoryRepository::class => autowire(InMemoryCategoryRepository::class),
        CustomerRepository::class => autowire(InMemoryCustomerRepository::class),
        ProductRepository::class => autowire(InMemoryProductRepository::class),
        DiscountService::class => autowire()
            ->constructor([
                autowire(SwitchesDiscountRule::class),
                autowire(ToolsDiscountRule::class),
                autowire(TotalSpentDiscountRule::class),
            ]),
        OrderService::class => autowire()
    ]);
};
