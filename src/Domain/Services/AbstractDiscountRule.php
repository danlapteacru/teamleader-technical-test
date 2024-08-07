<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Order\Order;
use App\Domain\ValueObjects\Discount;

abstract class AbstractDiscountRule implements DiscountRule
{
    /**
     * @var string
     */
    public static string $description;

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return static::$description;
    }

    abstract public function apply(Order $order): ?Discount;
}
