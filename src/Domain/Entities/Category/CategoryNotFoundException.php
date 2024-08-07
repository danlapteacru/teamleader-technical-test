<?php

declare(strict_types=1);

namespace App\Domain\Entities\Category;

use App\Domain\DomainException\DomainRecordNotFoundException;

class CategoryNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The category you requested does not exist.';
}
