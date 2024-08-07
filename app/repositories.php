<?php

declare(strict_types=1);

use App\Domain\Entities\Category\CategoryRepository;
use App\Domain\Entities\Product\ProductRepository;
use App\Infrastructure\Persistence\Category\InMemoryCategoryRepository;
use App\Infrastructure\Persistence\Product\InMemoryProductRepository;
use DI\ContainerBuilder;

use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        CategoryRepository::class => autowire(InMemoryCategoryRepository::class),
        ProductRepository::class => autowire(InMemoryProductRepository::class),
    ]);
};
