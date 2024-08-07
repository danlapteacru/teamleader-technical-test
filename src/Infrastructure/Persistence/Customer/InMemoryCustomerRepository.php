<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Customer;

use App\Domain\Entities\Customer\Customer;
use App\Domain\Entities\Customer\CustomerInvalidSinceDateException;
use App\Domain\Entities\Customer\CustomerNotFoundException;
use App\Domain\Entities\Customer\CustomerRepository;

class InMemoryCustomerRepository implements CustomerRepository
{
    /**
     * @var Customer[]
     */
    protected array $customers;

    /**
     * @param Customer[]|null $customers
     * @throws CustomerInvalidSinceDateException
     */
    public function __construct(array $customers = null)
    {
        $this->customers = $customers ?? [
            1 => new Customer(1, 'Coca Cola', '2014-06-28', 492.12),
            2 => new Customer(2, 'Teamleader', '2015-01-15', 1505.95),
            3 => new Customer(3, 'Jeroen De Wit', '2016-02-11'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->customers);
    }

    /**
     * {@inheritdoc}
     */
    public function findCustomerOfId(int $id): Customer
    {
        foreach ($this->findAll() as $customer) {
            if ($customer->getId() === $id) {
                return $customer;
            }
        }

        throw new CustomerNotFoundException();
    }
}
