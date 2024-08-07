<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Category;

use App\Domain\Entities\Category\Category;
use App\Domain\Entities\Category\CategoryNotFoundException;
use App\Domain\Entities\Category\CategoryRepository;

class InMemoryCategoryRepository implements CategoryRepository
{
    /**
     * @var Category[]
     */
    protected array $categories;

    /**
     * @param Category[]|null $users
     */
    public function __construct(array $users = null)
    {
        $this->categories = $users ?? [
            1 => new Category(1, 'Tools'),
            2 => new Category(2, 'Switches'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->categories);
    }

    /**
     * {@inheritdoc}
     */
    public function findCategoryOfId(int $id): Category
    {
        if (!isset($this->categories[$id])) {
            throw new CategoryNotFoundException();
        }

        return $this->categories[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function findCategoryOfName(string $name): Category
    {
        foreach ($this->categories as $category) {
            if ($category->getName() === $name) {
                return $category;
            }
        }

        throw new CategoryNotFoundException();
    }
}
