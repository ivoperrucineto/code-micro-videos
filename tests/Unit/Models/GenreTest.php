<?php

namespace Tests\Unit\Models;

use App\Models\Genre;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

class GenreTest extends TestCase
{
    public function testFillableAttribute()
    {
        $fillable = ['name', 'is_active'];
        $genre = new Genre();
        $this->assertEquals($fillable, $genre->getFillable());
    }

    public function testIfUseTraits()
    {
        $traits = [SoftDeletes::class, Uuid::class];
        $genreTraits = array_keys(class_uses(Genre::class));
        $this->assertEquals($traits, $genreTraits);
    }

    public function testCastsAttribute(){
        $casts = [
            'id' => "string",
            'is_active' => "boolean"
        ];
        $genre = new Genre();
        $this->assertEquals($casts, $genre->getCasts());
    }

    public function testIncrementingAttribute(){
        $genre = new Genre();
        $this->assertFalse($genre->getIncrementing());
    }

    public function testDatesAttribute(){
        $dates = [
            'deleted_at',
            'created_at',
            'updated_at'
        ];
        $genre = new Genre();
        $this->assertEqualsCanonicalizing($dates, $genre->getDates());
    }
}
