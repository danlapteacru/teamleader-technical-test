<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use App\Domain\ValueObjects\Discount;
use App\Domain\ValueObjects\Money;
use Tests\TestCase;

class DiscountTest extends TestCase
{
    public function discountProvider(): array
    {
        return [
            ['Test reason', new Money(1.00)],
            ['Another reason', new Money(2.00)],
        ];
    }

    /**
     * @dataProvider discountProvider
     * @param string $reason
     * @param Money $amount
     */
    public function testGetters(string $reason, Money $amount): void
    {
        $discount = new Discount($reason, $amount);

        $this->assertEquals($reason, $discount->getReason());
        $this->assertEquals($amount, $discount->getAmount());
    }

    /**
     * @dataProvider discountProvider
     * @param string $reason
     * @param Money $amount
     */
    public function testToString(string $reason, Money $amount): void
    {
        $discount = new Discount($reason, $amount);

        $this->assertEquals(sprintf('%s: %s', $reason, (string) $amount), (string) $discount);
    }

    /**
     * @dataProvider discountProvider
     * @param string $reason
     * @param Money $amount
     */
    public function testJsonSerialize(string $reason, Money $amount): void
    {
        $discount = new Discount($reason, $amount);

        $expectedPayload = json_encode([
            'reason' => $reason,
            'amount' => (string) $amount,
        ]);

        $this->assertEquals($expectedPayload, json_encode($discount->jsonSerialize()));
    }
}
