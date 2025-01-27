<?php

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;

beforeEach(function (){
    // create some purchases
    $this->purchases = Purchase::factory()->has(PurchaseItem::factory(3))->count(10)->create();
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

    test('include supplier and purchase items', function (){
        $response = $this->getJson(route('api.purchases.index', ['include' =>'supplier,purchaseItems']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'supplier_id', 'total_amount', 'created_at', 'updated_at','purchase_items','supplier'],
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
        ]);
    });
});

describe('Show', function (){
    test('returns a single purchase', function (){
        $response = $this->getJson(route('api.purchases.show', $this->purchase));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['id', 'supplier_id', 'total_amount', 'created_at', 'updated_at'],
        ]);
    });

    test('include supplier and purchase items', function (){
        $response = $this->getJson(route('api.purchases.show', ['purchase' => $this->purchase->id,'include' =>'supplier,purchaseItems']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['id', 'supplier_id', 'total_amount', 'created_at', 'updated_at','purchase_items','supplier'],
        ]);
    });
});

describe('Store', function (){
    test('creates a new purchase with valid data', function (){
        $response = $this->postJson(route('api.purchases.store'), $this->payload);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => ['id', 'supplier_id', 'total_amount', 'created_at', 'updated_at'],
        ]);
    });

    test('returns error when creating a new purchase with invalid data', function (){
        $this->payload['supplier_id'] = null;
        $response = $this->postJson(route('api.purchases.store'), $this->payload);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => ['supplier_id']
        ]);
    });
});

describe('Update', function (){
    test('updates an existing purchase with valid data', function (){
        $response = $this->putJson(route('api.purchases.update', $this->purchase), $this->payload);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['id', 'supplier_id', 'total_amount', 'created_at', 'updated_at'],
        ]);
    });

    test('returns error when updating an existing purchase with invalid data', function (){
        $this->payload['supplier_id'] = null;
        $response = $this->putJson(route('api.purchases.update', $this->purchase), $this->payload);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => ['supplier_id']
        ]);
    });
});

describe('Destroy', function (){
    test('deletes an existing purchase', function (){
        $response = $this->deleteJson(route('api.purchases.destroy', $this->purchase));
        $response->assertStatus(204);
        // assert soft deleted
        $this->assertSoftDeleted('purchases', ['id' => $this->purchase->id]);
    });

    test('returns error when deleting a non-existing purchase', function (){
        $response = $this->deleteJson(route('api.purchases.destroy', ['purchase' => 9999999999]));
        $response->assertStatus(404);
    });
});
