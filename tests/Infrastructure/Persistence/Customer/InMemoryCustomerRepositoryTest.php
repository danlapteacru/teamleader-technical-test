<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Customer;

use App\Domain\Entities\Customer\Customer;
use App\Domain\Entities\Customer\CustomerInvalidSinceDateException;
use App\Domain\Entities\Customer\CustomerNotFoundException;
use App\Infrastructure\Persistence\Customer\InMemoryCustomerRepository;
use Tests\TestCase;

class InMemoryCustomerRepositoryTest extends TestCase
{
    /**
     * @throws CustomerInvalidSinceDateException
     */
    public function testFindAll()
    {
        $user = new Customer(1, 'Coca Cola', '2014-06-28', 492.12);

        $userRepository = new InMemoryCustomerRepository([1 => $user]);

        $this->assertEquals([$user], $userRepository->findAll());
    }

    /**
     * @throws CustomerInvalidSinceDateException
     */
    public function testFindAllUsersByDefault()
    {
        $users = [
            1 => new Customer(1, 'Coca Cola', '2014-06-28', 492.12),
            2 => new Customer(2, 'Teamleader', '2015-01-15', 1505.95),
            3 => new Customer(3, 'Jeroen De Wit', '2016-02-11'),
        ];

        $userRepository = new InMemoryCustomerRepository();

        $this->assertEquals(array_values($users), $userRepository->findAll());
    }

    /**
     * @throws CustomerNotFoundException|CustomerInvalidSinceDateException
     */
    public function testFindUserOfId()
    {
        $user = new Customer(1, 'Coca Cola', '2014-06-28', 492.12);

        $userRepository = new InMemoryCustomerRepository([1 => $user]);

        $this->assertEquals($user, $userRepository->findCustomerOfId(1));
    }

    /**
     * @throws CustomerInvalidSinceDateException
     */
    public function testFindUserOfIdThrowsCustomerInvalidSinceDateException()
    {
        $this->expectException(CustomerInvalidSinceDateException::class);
        new Customer(1, 'Coca Cola', 'test', 492.12);
    }
}
