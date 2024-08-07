<?php

declare(strict_types=1);

namespace Tests\Domain\Entities\Customer;

use App\Domain\Entities\Customer\Customer;
use App\Domain\Entities\Customer\CustomerInvalidSinceDateException;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    public function customerProvider(): array
    {
        return [
            [1, 'Coca Cola', '2014-06-28', 492.12],
            [2, 'Teamleader', '2015-01-15', 1505.95],
            [3, 'Jeroen De Wit', '2016-02-11', 0.00],
        ];
    }

    /**
     * @dataProvider customerProvider
     * @param int $id
     * @param string $name
     * @param string $since
     * @param float $revenue
     * @throws CustomerInvalidSinceDateException
     */
    public function testGetters(int $id, string $name, string $since, float $revenue)
    {
        $customer = new Customer($id, $name, $since, $revenue);

        $this->assertEquals($id, $customer->getId());
        $this->assertEquals($name, $customer->getName());
        $this->assertEquals($since, $customer->getSinceAsString());
        $this->assertEquals($revenue, $customer->getRevenue()->getAmount());
    }

    /**
     * @dataProvider customerProvider
     * @param int $id
     * @param string $name
     * @param string $since
     * @param float $revenue
     * @throws CustomerInvalidSinceDateException
     */
    public function testJsonSerialize(int $id, string $name, string $since, float $revenue)
    {
        $customer = new Customer($id, $name, $since, $revenue);

        $expectedPayload = json_encode([
            'id' => $id,
            'name' => $name,
            'since' => $since,
            'revenue' => $revenue,
        ]);

        $this->assertEquals($expectedPayload, json_encode($customer));
    }
}
