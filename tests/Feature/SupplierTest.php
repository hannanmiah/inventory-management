<?php

use App\Models\Ledger;
use App\Models\Supplier;

beforeEach(function () {
    // create some suppliers
    $this->suppliers = Supplier::factory()->has(Ledger::factory())->count(10)->create();
    $this->supplier = $this->suppliers->random();

    // create payload for post and update route
    $this->payload = [
        'name' => 'New Name',
        'address' => 'Trishal, Mymensingh',
        'contact_info' => [
            'phone' => '01712345678',
            'email' => 'johndoe@example.com'
        ]
    ];
});

describe('Index', function () {
    test('returns paginated list of suppliers', function () {
        $response = $this->getJson(route('api.suppliers.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'address', 'contact_info', 'created_at', 'updated_at'],
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
        ]);
    });
    test('include ledger,purchases',function (){
        $response = $this->getJson(route('api.suppliers.index', ['include' => 'ledger,purchases']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'address', 'contact_info', 'created_at', 'updated_at', 'ledger' => ['id', 'supplier_id', 'credit', 'debit', 'balance', 'transaction_date', 'remarks', 'created_at', 'updated_at'], 'purchases' => [
                    '*' => ['id', 'supplier_id', 'total_amount', 'created_at', 'updated_at']
                ]],
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
        ]);
    });
});

describe('Show', function () {
    test('returns a single supplier', function () {
        $response = $this->getJson(route('api.suppliers.show', ['supplier' => $this->supplier->id,'include' => 'ledger,purchases']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'address', 'contact_info', 'created_at', 'updated_at', 'ledger' => ['id', 'supplier_id', 'credit', 'debit', 'balance', 'transaction_date', 'remarks', 'created_at', 'updated_at'], 'purchases' => [
                '*' => ['id', 'supplier_id', 'total_amount', 'created_at', 'updated_at']
            ]],
        ]);
    });
    test('404 for non-existing supplier', function () {
        $response = $this->getJson(route('api.suppliers.show', 99999));
        $response->assertStatus(404);
    });
});

describe('Store', function () {
    test('creates a new supplier with valid data', function () {
        $response = $this->postJson(route('api.suppliers.store'), $this->payload);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'address', 'contact_info', 'created_at', 'updated_at'],
        ]);
    });
    test('returns validation errors for invalid data', function () {
        $response = $this->postJson(route('api.suppliers.store'), []);
        $response->assertStatus(422);
    });
});

describe('Update', function () {
    test('updates an existing supplier with valid data', function () {
        $response = $this->putJson(route('api.suppliers.update', $this->supplier), $this->payload);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'address', 'contact_info', 'created_at', 'updated_at'],
        ]);
    });
    test('returns validation errors for invalid data', function () {
        $response = $this->putJson(route('api.suppliers.update', ['supplier' => $this->supplier->id]), [
            'address' => 2000
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['address']);
    });
});

describe('Destroy', function () {
    test('deletes an existing supplier', function () {
        $response = $this->deleteJson(route('api.suppliers.destroy', $this->supplier));
        $response->assertStatus(204);
        // assert soft deleted
        $this->assertSoftDeleted('suppliers', ['id' => $this->supplier->id]);
    });
    test('404 for non-existing supplier', function () {
        $response = $this->deleteJson(route('api.suppliers.destroy', 99999));
        $response->assertStatus(404);
    });
});