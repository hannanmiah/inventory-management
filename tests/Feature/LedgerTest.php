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
});
