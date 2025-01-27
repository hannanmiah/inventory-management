<?php

use App\Models\Product;

beforeEach(function () {
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

describe('Index', function () {
    test('returns paginated list of products', function () {
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

    test('includes related category and purchase items', function () {
        $response = $this->getJson(route('api.products.index', ['include' => 'category,purchaseItems']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'current_stock_quantity', 'price', 'category_id', 'created_at', 'updated_at', 'category' => ['id', 'name', 'created_at', 'updated_at'], 'purchase_items' => [
                    '*' => ['id', 'product_id', 'quantity', 'created_at', 'updated_at']
                ]],
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
        ]);
    });

    test('filter by category_id', function () {
        $response = $this->getJson(route('api.products.index', ['filter[category_id]' => $this->product->category_id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'current_stock_quantity', 'price', 'category_id', 'created_at', 'updated_at'],
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
        ]);
        // assert json count container one result
        $response->assertJsonCount(1,'data');
    });
});

describe('Show', function () {
    test('returns a single product with related category and purchase items', function () {
        $response = $this->getJson(route('api.products.show', ['product' => $this->product->id,'include' => 'category,purchaseItems']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'current_stock_quantity', 'price', 'category_id', 'created_at', 'updated_at', 'category' => ['id', 'name', 'created_at', 'updated_at'], 'purchase_items' => [
                '*' => ['id', 'product_id', 'quantity', 'created_at', 'updated_at']
            ]],
        ]);
    });
});

describe('Store', function () {
    test('creates a new product with valid data', function () {
        $response = $this->postJson(route('api.products.store'), $this->payload);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'current_stock_quantity', 'price', 'category_id', 'created_at', 'updated_at'],
        ]);
    });

    test('returns validation errors for invalid data', function () {
        $response = $this->postJson(route('api.products.store'), []);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => ['name', 'initial_stock_quantity', 'price', 'category_id'],
        ]);
    });
});

describe('Update', function () {
    test('updates an existing product with valid data', function () {
        $response = $this->putJson(route('api.products.update', ['product' => $this->product->id]), $this->payload);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'current_stock_quantity', 'price', 'category_id', 'created_at', 'updated_at'],
        ]);
    });

    test('returns validation errors for invalid price', function () {
        $response = $this->putJson(route('api.products.update', ['product' => $this->product->id]), ['price' => -100]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => ['price'],
        ]);
    });
});

describe('Destroy', function () {
    test('deletes an existing product', function () {
        $response = $this->deleteJson(route('api.products.destroy', ['product' => $this->product->id]));
        $response->assertStatus(204);
        // assert soft deleted
        $this->assertSoftDeleted('products', ['id' => $this->product->id]);
    });

    test('returns 404 for non-existing product', function () {
        $response = $this->deleteJson(route('api.products.destroy', ['product' => 9999]));
        $response->assertStatus(404);
    });
});
