<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use App\Domain\ValueObjects\Money;
use Tests\TestCase;

class MoneyTest extends TestCase
{
    public function moneyProvider(): array
    {
        return [
            [1.00],
            [2.50],
            [5.00],
            [10.00],
            [20.00],
        ];
    }

    /**
     * @dataProvider moneyProvider
     * @param float $amount
     */
    public function testGetAmount(float $amount): void
    {
        $money = new Money($amount);
        $this->assertEquals($amount, $money->getAmount());
    }

    /**
     * @dataProvider moneyProvider
     * @param float $amount
     */
    public function testAdd(float $amount): void
    {
        $money = new Money($amount);
        $this->assertEquals($amount + 1.00, $money->add(new Money(1.00))->getAmount());
    }

    /**
     * @dataProvider moneyProvider
     * @param float $amount
     */
    public function testSubtract(float $amount): void
    {
        $money = new Money($amount);
        $this->assertEquals($amount - 1.00, $money->subtract(new Money(1.00))->getAmount());
    }

    /**
     * @dataProvider moneyProvider
     * @param float $amount
     */
    public function testMultiply(float $amount): void
    {
        $money = new Money($amount);
        $this->assertEquals($amount * 2, $money->multiply(2)->getAmount());
    }

    /**
     * @dataProvider moneyProvider
     * @param float $amount
     */
    public function testIsGreaterThan(float $amount): void
    {
        $money = new Money($amount);
        $this->assertTrue($money->isGreaterThan(new Money($amount - 1.00)));
        $this->assertFalse($money->isGreaterThan(new Money($amount + 1.00)));
    }

    /**
     * @dataProvider moneyProvider
     * @param float $amount
     */
    public function testIsGreaterThanOrEqual(float $amount): void
    {
        $money = new Money($amount);
        $this->assertTrue($money->isGreaterThanOrEqual(new Money($amount - 1.00)));
        $this->assertTrue($money->isGreaterThanOrEqual(new Money($amount)));
        $this->assertFalse($money->isGreaterThanOrEqual(new Money($amount + 1.00)));
    }

    /**
     * @dataProvider moneyProvider
     * @param float $amount
     */
    public function testToString(float $amount): void
    {
        $money = new Money($amount);
        $this->assertEquals(number_format($amount, 2), (string) $money);
    }
}
