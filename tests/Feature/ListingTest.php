<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Listing;
use App\User;

class ListingTest extends TestCase
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

    /**
     * test to get all products
     */
    public function testGetAllListings(){
        \factory(Listing::class,5)->create();
        $response = $this->json('GET','/api/listings');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'name',
                'description',
                
            ]
        ]);
    }

    public function testCreateListingWithoutCategories(){
        $user = factory(User::class)->create();
        $list = factory(Listing::class)->make()->toArray();
        $response = $this->json('POST','/api/listings',$list);
        $response->assertStatus(200);
    }

    public function testUpdateListingWithoutCategories(){
        $user = factory(User::class)->create();
        $list = factory(Listing::class)->create();
        $data = ['name'=>'new listing', 'description'=>'halla'];
        $response = $this->json('PUT',"/api/listings/{$list->id}",$data);
        $response->assertStatus(200);
    }
}
