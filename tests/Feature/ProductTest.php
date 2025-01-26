<?php

use App\Models\Product;

beforeEach(function (){
    // create some products
    $this->products = Product::factory()->count(10)->create();
    $this->product = $this->products->random();

    // create payload for post and update route
    $this->payload = [
        'name' => 'New Name',
        'initial_stock_quantity' => 10,
        'current_stock_quantity' => 5,
        'price' => 100,
        'category_id' => $this->products->first()->category_id
    ];
});

describe('Index',function (){
    test('returns paginated list of products',function (){
        $response = $this->getJson(route('api.products.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'current_stock_quantity', 'price', 'category_id', 'created_at', 'updated_at'],
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
        ]);
    });
});
