<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Category;

use App\Domain\Entities\Category\Category;
use App\Domain\Entities\Category\CategoryNotFoundException;
use App\Infrastructure\Persistence\Category\InMemoryCategoryRepository;
use Tests\TestCase;

class InMemoryCategoryRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $category = new Category(1, 'Tools');

        $categoryRepository = new InMemoryCategoryRepository([1 => $category]);

        $this->assertEquals([$category], $categoryRepository->findAll());
    }

    public function testFindAllCategoriesByDefault()
    {
        $categories = [
            1 => new Category(1, 'Tools'),
            2 => new Category(2, 'Switches'),
        ];

        $categoryRepository = new InMemoryCategoryRepository();

        $this->assertEquals(array_values($categories), $categoryRepository->findAll());
    }

    /**
     * @throws CategoryNotFoundException
     */
    public function testFindCategoryOfId()
    {
        $category = new Category(1, 'Tools');

        $categoryRepository = new InMemoryCategoryRepository([1 => $category]);

        $this->assertEquals($category, $categoryRepository->findCategoryOfId(1));
    }

    /**
     * @throws CategoryNotFoundException
     */
    public function testFindCategoryOfName()
    {
        $category = new Category(1, 'Tools');

        $categoryRepository = new InMemoryCategoryRepository([1 => $category]);

        $this->assertEquals($category, $categoryRepository->findCategoryOfName('Tools'));
    }

    public function testFindUserOfIdThrowsNotFoundException()
    {
        $categoryRepository = new InMemoryCategoryRepository([]);
        $this->expectException(CategoryNotFoundException::class);
        $categoryRepository->findCategoryOfId(1);
    }
}
