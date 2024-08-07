<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Order\Order;
use App\Domain\ValueObjects\Discount;

interface DiscountRule
{
    public function apply(Order $order): ?Discount;
}
