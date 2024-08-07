<?php

declare(strict_types=1);

namespace App\Domain\Entities\Category;

use JsonSerializable;

class Category implements JsonSerializable
{
    /**
     * @var int The category ID
     */
    protected int $id;

    /**
     * @var string The category name
     */
    protected string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
