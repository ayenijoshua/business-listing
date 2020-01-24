<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Listing;

class ListingTest extends TestCase
{
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
        \factory(Listing::class,5)->state('sku')->create();
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
}
