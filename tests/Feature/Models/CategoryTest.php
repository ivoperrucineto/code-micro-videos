<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Category::class)->create();
        $categories = Category::all();
        $this->assertCount(1, $categories);

        $categoryKey = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'description',
                'is_active',
                'deleted_at',
                'created_at',
                'updated_at'
            ],
            $categoryKey
        );
    }

    public function testCreate()
    {
        $category = Category::create([
            'name' => 'category'
        ]);
        $category->refresh();
        $this->assertEquals('category', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);
        $this->assertTrue(Uuid::isValid($category->id));

        $category = Category::create([
            'name' => 'category',
            'description' => null
        ]);
        $this->assertNull($category->description);

        $category = Category::create([
            'name' => 'category',
            'description' => 'test'
        ]);
        $this->assertEquals('test', $category->description);

        $category = Category::create([
            'name' => 'category',
            'is_active' => false
        ]);
        $this->assertFalse($category->is_active);

        $category = Category::create([
            'name' => 'category',
            'is_active' => true
        ]);
        $this->assertTrue($category->is_active);
    }

    public function testUpdate()
    {
        /** @var Category $category **/
        $category = factory(Category::class)->create([
            'description' => 'test',
            'is_active' => false
        ]);

        $data = [
            'name' => 'new_name',
            'description' => 'new_description',
            'is_active' => true
        ];

        $category->update($data);
        foreach ($data as $key => $value){
            $this->assertEquals($value, $category->{$key});
        }
    }

    public function testDelete()
    {
        $category = factory(Category::class)->create();
        $category->delete();
        $this->assertCount(0, $category->all());
    }
}
