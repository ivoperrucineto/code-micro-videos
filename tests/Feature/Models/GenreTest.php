<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Genre::class)->create();
        $genres = Genre::all();
        $this->assertCount(1, $genres);

        $genresKey = array_keys($genres->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'is_active',
                'deleted_at',
                'created_at',
                'updated_at'
            ],
            $genresKey
        );
    }

    public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'genre'
        ]);
        $genre->refresh();
        $this->assertEquals('genre', $genre->name);
        $this->assertTrue($genre->is_active);
        $this->assertTrue(Uuid::isValid($genre->id));

        $genre = Genre::create([
            'name' => 'genre',
            'is_active' => false
        ]);
        $this->assertFalse($genre->is_active);

        $genre = Genre::create([
            'name' => 'genre',
            'is_active' => true
        ]);
        $this->assertTrue($genre->is_active);
    }

    public function testUpdate()
    {
        /** @var Genre $genre **/
        $genre = factory(Genre::class)->create([
            'is_active' => false
        ]);

        $data = [
            'name' => 'new_name',
            'is_active' => true
        ];

        $genre->update($data);
        foreach ($data as $key => $value){
            $this->assertEquals($value, $genre->{$key});
        }
    }

    public function testDelete()
    {
        $genre=factory(Genre::class)->create();
        $genre->delete();
        $id = $genre->id;
        $this->assertNull($genre->find($id));

        $genre->restore();
        $this->assertNotNull($genre->find($id));
    }
}
