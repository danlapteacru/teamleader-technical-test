<?php

declare(strict_types=1);

namespace Tests\Domain\Entities\Category;

use App\Domain\Entities\Category\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function categoryProvider(): array
    {
        return [
            [1, 'Tools'],
            [2, 'Switches'],
        ];
    }

    /**
     * @dataProvider categoryProvider
     * @param int $id
     * @param string $name
     */
    public function testGetters(int $id, string $name): void
    {
        $category = new Category($id, $name);

        $this->assertEquals($id, $category->getId());
        $this->assertEquals($name, $category->getName());
    }

    /**
     * @dataProvider categoryProvider
     * @param int $id
     * @param string $name
     */
    public function testJsonSerialize(int $id, string $name): void
    {
        $category = new Category($id, $name);

        $expectedPayload = json_encode([
            'id' => $id,
            'name' => $name,
        ]);

        $this->assertEquals($expectedPayload, json_encode($category));
    }
}
