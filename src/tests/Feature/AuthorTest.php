<?php

namespace Tests\Feature;

use App\Models\Blog\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    /**
     * test create new author feature
     * api method: AuthorController@store
     *
     * @return void
     */
    public function test_authors_create()
    {
        //generate a post model without persisting in db
        $payload = Author::factory()->make();

        $this->json('POST', '/api/authors', $payload->toArray())
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $payload->name
                ]
            ]);
    }



    /**
     * test author list feature
     * api method: AuthorController@index
     * @return void
     */
    public function test_authors_list()
    {
        $author = Author::factory()->create();

        $this->json('GET', '/api/authors')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $author->id,
                        'name' => $author->name
                    ]
                ]
            ]);

    }
}
