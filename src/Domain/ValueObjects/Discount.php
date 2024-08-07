<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

class Discount
{
    /**
     * @var string The reason for the discount
     */
    protected string $reason;

    /**
     * @var Money The amount of the discount
     */
    protected Money $amount;

    public function __construct(string $reason, Money $amount)
    {
        $this->reason = $reason;
        $this->amount = $amount;
    }

    public function getReason(): string
    {
        return $this->reason;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function __toString(): string
    {
        return sprintf('%s: %s', $this->reason, (string) $this->amount);
    }

    public function jsonSerialize(): array
    {
        return [
            'reason' => $this->reason,
            'amount' => (string) $this->amount,
        ];
    }
}
