<?php

use App\Models\Supplier;

beforeEach(function () {
    // create some suppliers
    $this->suppliers = Supplier::factory()->count(10)->create();
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
});