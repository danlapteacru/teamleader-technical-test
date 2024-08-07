<?php

declare(strict_types=1);

namespace App\Domain\Entities\Customer;

use App\Domain\DomainException\DomainRecordNotFoundException;

class CustomerInvalidSinceDateException extends DomainRecordNotFoundException
{
    public $message = 'The since date is invalid.';
}
