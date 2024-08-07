<?php

declare(strict_types=1);

namespace App\Domain\Entities\Customer;

use App\Domain\ValueObjects\Money;
use Exception;
use DateTimeImmutable;
use JsonSerializable;

class Customer implements JsonSerializable
{
    /**
     * @var int The customer ID
     */
    protected int $id;

    /**
     * @var string The customer name
     */
    protected string $name;

    /**
     * @var bool|DateTimeImmutable The date since the customer is active
     */
    protected bool|DateTimeImmutable $since;

    /**
     * @var float|null The total amount spent by the customer
     */
    protected ?float $revenue;

    /**
     * @throws CustomerInvalidSinceDateException
     */
    public function __construct(int $id, string $name, string $since, ?float $revenue = null)
    {
        $this->id = $id;
        $this->name = $name;

        $this->since = DateTimeImmutable::createFromFormat('Y-m-d', $since);
        if (! $this->since instanceof DateTimeImmutable) {
            throw new CustomerInvalidSinceDateException();
        }

        $this->revenue = $revenue ?? 0.00;
    }

    /**
     * Get the customer ID
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSince(): DateTimeImmutable
    {
        return $this->since;
    }

    public function getSinceAsString(): string
    {
        return $this->since->format('Y-m-d');
    }

    /**
     * Get the total amount spent by the customer
     * @return Money|null
     */
    public function getRevenue(): ?Money
    {
        return new Money($this->revenue);
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'since' => $this->getSinceAsString(),
            'revenue' => $this->revenue,
        ];
    }
}
