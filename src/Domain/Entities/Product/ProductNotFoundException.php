<?php

declare(strict_types=1);

namespace App\Domain\Entities\Product;

use App\Domain\DomainException\DomainRecordNotFoundException;

class ProductNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The product you requested does not exist.';
}
