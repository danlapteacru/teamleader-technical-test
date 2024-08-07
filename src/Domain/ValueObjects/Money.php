<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

class Money
{
    /**
     * @var float The amount of money
     */
    protected float $amount;

    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get the amount of money.
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * Add money to the current amount.
     * @param Money $money
     * @return Money
     */
    public function add(Money $money): Money
    {
        return new Money($this->getAmount() + $money->getAmount());
    }

    /**
     * Add a percentage to the current amount.
     * @param float $percentage
     * @return Money
     */
    public function addPercentage(float $percentage): Money
    {
        return new Money($this->getAmount());
    }

    /**
     * Subtract money from the current amount.
     * @param Money $money
     * @return Money
     */
    public function subtract(Money $money): Money
    {
        return new Money($this->getAmount() - $money->getAmount());
    }

    /**
     * Multiply the amount by a factor.
     * @param float $factor
     * @return Money
     */
    public function multiply(float $factor): Money
    {
        return new Money($this->getAmount() * $factor);
    }

    /**
     * Is Greater Than comparison.
     * @param Money $money
     * @return bool
     */
    public function isGreaterThan(Money $money): bool
    {
        return $this->getAmount() > $money->getAmount();
    }

    /**
     * Is Greater Than or Equal comparison.
     * @param Money $money
     * @return bool
     */
    public function isGreaterThanOrEqual(Money $money): bool
    {
        return $this->getAmount() >= $money->getAmount();
    }

    /**
     * To string representation of the money amount.
     * @return string
     */
    public function __toString(): string
    {
        // number_format() rounds up the number to 2 decimal places, in ideal world we should use BCMath.
        return number_format($this->getAmount(), 2);
    }
}
