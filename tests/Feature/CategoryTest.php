<?php

use App\Models\Category;
use App\Models\Product;

beforeEach(function (){
    // create some categories
    $this->categories = Category::factory()->has(Product::factory(3))->count(5)->create();
    $this->category = $this->categories->random();

    // create payload for post and update route
    $this->payload = [
        'name' => 'New Name'
    ];
});

describe('Index',function (){
    test('returns paginated list of categories',function (){
        $response = $this->getJson(route('api.categories.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'created_at', 'updated_at'],
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
        ]);
    });
});
