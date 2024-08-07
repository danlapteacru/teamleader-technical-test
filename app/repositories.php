<?php

declare(strict_types=1);

use App\Domain\Entities\Product\ProductRepository;
use App\Infrastructure\Persistence\Product\InMemoryProductRepository;
use DI\ContainerBuilder;

use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        ProductRepository::class => autowire(InMemoryProductRepository::class),
    ]);
};
