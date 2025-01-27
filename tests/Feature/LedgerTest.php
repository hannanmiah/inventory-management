<?php

use App\Models\Ledger;

beforeEach(function () {
    // create some ledgers
    $this->ledgers = Ledger::factory()->count(10)->create();
    $this->ledger = $this->ledgers->random();

    // create payload for post and update route
    $this->payload = [
        'supplier_id' => $this->ledgers->random()->supplier_id,
        'credit' => 100,
        'debit' => 50,
        'remarks' => 'New Description',
        'transaction_date' => now()
    ];
});

describe('Index', function () {
    test('returns paginated list of ledgers', function () {
        $response = $this->getJson(route('api.ledgers.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'supplier_id', 'credit', 'debit', 'balance', 'transaction_date', 'remarks', 'created_at', 'updated_at'],
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
        ]);
    });
    test('include supplier', function () {
        $response = $this->getJson(route('api.ledgers.index', ['include' =>'supplier']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'supplier_id', 'credit', 'debit', 'balance', 'transaction_date', 'remarks', 'created_at', 'updated_at','supplier'],
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
        ]);
    });

    test('filter by supplier_id', function () {
        $response = $this->getJson(route('api.ledgers.index', ['filter[supplier_id]' => $this->ledger->supplier_id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'supplier_id', 'credit', 'debit', 'balance', 'transaction_date', 'remarks', 'created_at', 'updated_at'],
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
        ]);
        // assert record has single item
        $response->assertJsonCount(1,'data');
    });
});

describe('Show', function () {
    test('returns a single ledger', function () {
        $response = $this->getJson(route('api.ledgers.show', $this->ledger));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['id', 'supplier_id', 'credit', 'debit', 'balance', 'transaction_date', 'remarks', 'created_at', 'updated_at'],
        ]);
    });
    test('include supplier', function () {
        $response = $this->getJson(route('api.ledgers.show', ['ledger' => $this->ledger,'include' =>'supplier']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['id', 'supplier_id', 'credit', 'debit', 'balance', 'transaction_date', 'remarks', 'created_at', 'updated_at','supplier'],
        ]);
    });
    test('404 for non-existing ledger', function () {
        $response = $this->getJson(route('api.ledgers.show', 99999));
        $response->assertStatus(404);
    });
});

describe('Store', function () {
    test('creates a new ledger with valid data', function () {
        $response = $this->postJson(route('api.ledgers.store'), $this->payload);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => ['id', 'supplier_id', 'credit', 'debit', 'balance', 'transaction_date', 'remarks', 'created_at', 'updated_at'],
        ]);
    });
    test('returns validation errors for invalid data', function () {
        $response = $this->postJson(route('api.ledgers.store'), []);
        $response->assertStatus(422);
    });
});

describe('Update', function () {
    test('updates an existing ledger with valid data', function () {
        $response = $this->putJson(route('api.ledgers.update', $this->ledger), $this->payload);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['id', 'supplier_id', 'credit', 'debit', 'balance', 'transaction_date', 'remarks', 'created_at', 'updated_at'],
        ]);
    });
    test('returns validation errors for invalid data', function () {
        $response = $this->putJson(route('api.ledgers.update', $this->ledger), ['supplier_id' => null]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => ['supplier_id'],
        ]);
    });
    test('404 for non-existing ledger', function () {
        $response = $this->putJson(route('api.ledgers.update', 99999), $this->payload);
        $response->assertStatus(404);
    });
});

describe('Destroy', function () {
    test('deletes an existing ledger', function () {
        $response = $this->deleteJson(route('api.ledgers.destroy', $this->ledger));
        $response->assertStatus(204);
        // assert soft deleted
        $this->assertSoftDeleted('ledgers', ['id' => $this->ledger->id]);
    });
    test('returns error when deleting a non-existing ledger', function () {
        $response = $this->deleteJson(route('api.ledgers.destroy', 99999));
        $response->assertStatus(404);
    });
});
