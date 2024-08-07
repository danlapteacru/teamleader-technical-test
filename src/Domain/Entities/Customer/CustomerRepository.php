<?php

declare(strict_types=1);

namespace App\Domain\Entities\Customer;

interface CustomerRepository
{
    /**
     * @return Customer[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Customer
     * @throws CustomerNotFoundException
     */
    public function findCustomerOfId(int $id): Customer;
}
