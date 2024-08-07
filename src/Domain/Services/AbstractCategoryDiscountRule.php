<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Category\CategoryNotFoundException;
use App\Domain\Entities\Category\CategoryRepository;

abstract class AbstractCategoryDiscountRule extends AbstractDiscountRule implements DiscountRule
{
    /**
     * @var CategoryRepository|null
     */
    protected ?CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @throws CategoryNotFoundException
     */
    public function getCategoryIdByName(string $categoryName): int
    {
        $category = $this->categoryRepository->findCategoryOfName($categoryName);
        return $category->getId();
    }
}
