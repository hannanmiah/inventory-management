<?php

use App\Models\Product;
use App\Models\Purchase;

beforeEach(function (){
    // create some purchases
    $this->purchases = Purchase::factory()->count(10)->create();
    $this->purchase = $this->purchases->random();
    $this->products = Product::factory(3)->create();

    // create payload for post and update route
    $this->payload = [
        'supplier_id' => $this->purchases->random()->supplier_id,
        'total_amount' => 500,
        'items' => [
            [
                'product_id' => $this->products->first()->id,
                'quantity' => 2,
                'unit_price' => 100,
                'total_price' => 200,
            ],
            [
                'product_id' => $this->products->last()->id,
                'quantity' => 1,
                'unit_price' => 200,
                'total_price' => 200,
            ]
        ]
    ];
});

describe('Index',function (){
    test('returns paginated list of purchases',function (){
        $response = $this->getJson(route('api.purchases.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'supplier_id', 'total_amount', 'created_at', 'updated_at'],
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
        ]);
    });
});
