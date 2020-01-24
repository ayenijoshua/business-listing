<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testGetAllCategories(){
        \factory(Category::class,5)->create();
        $response = $this->json('GET','/api/categories');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'name',
                'description',
            ]
        ]);
    }

    public function testCreateCategory(){
        //$user = factory(User::class)->create();
        $category = factory(Category::class)->make()->toArray();
        $response = $this->json('POST','/api/categories',$category);
        $response->assertStatus(201);
    }

    public function testUpdateCategory(){
        //$user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $data = ['name'=>'new category', 'description'=>'halla'];
        $response = $this->json('PUT',"/api/categories/{$category->id}",$data);
        $response->assertStatus(201);
    }
}
