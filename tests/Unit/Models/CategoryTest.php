<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{

    public function testFillableAttribute()
    {
        $fillable = ['name', 'description', 'is_active'];
        $category = new Category();
        $this->assertEquals($fillable, $category->getFillable());
    }

    public function testIfUseTraits()
    {
        $traits = [SoftDeletes::class, Uuid::class];
        $categoryTraits = array_keys(class_uses(Category::class));
        $this->assertEquals($traits, $categoryTraits);
    }

    public function testCastsAttribute(){
        $casts = [
            'id' => "string",
            'is_active' => "boolean"
        ];
        $category = new Category();
        $this->assertEquals($casts, $category->getCasts());
    }

    public function testIncrementingAttribute(){
        $category = new Category();
        $this->assertFalse($category->getIncrementing());
    }

    public function testDatesAttribute(){
        $dates = [
            'deleted_at',
            'created_at',
            'updated_at'
            ];
        $category = new Category();
        $this->assertEqualsCanonicalizing($dates, $category->getDates());
    }
}
