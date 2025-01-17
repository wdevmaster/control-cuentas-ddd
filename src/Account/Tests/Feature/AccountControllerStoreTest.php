<?php

namespace Bank\Account\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountControllerStoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_StoreWithValidData()
    {
        $data = [
            'accountNumber' => str_pad((string)rand(0, 9999999999), 10, '0', STR_PAD_LEFT),
            'accountName' => 'John Doe',
            'currency' => 'USD',
            'balance' => 1000.00,
        ];

        $response = $this->postJson('/api/accounts', $data);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'id',
                    'account_number',
                    'account_name',
                    'currency',
                    'balance',
                ]);

        $this->assertDatabaseHas('accounts', [
            'account_number' => $data['accountNumber'],
            'account_name' => $data['accountName'],
            'currency' => $data['currency'],
            'balance' => $data['balance'],
        ]);
    }

    public function test_StoreWithInvalidData()
    {
        $data = [
            'accountNumber' => '',
            'accountName' => '',
            'currency' => '',
            'balance' => -1000.00,
        ];

        $response = $this->postJson('/api/accounts', $data);

        $response->assertStatus(422)
                ->assertJsonStructure([
                    'errors' => [
                        'accountNumber',
                        'accountName',
                        'currency',
                        'balance',
                    ],
                ]);
    }

    public function test_StoreWithMissingData()
    {
        $data = [];

        $response = $this->postJson('/api/accounts', $data);

        $response->assertStatus(422)
                ->assertJsonStructure([
                    'errors' => [
                        'accountNumber',
                        'accountName',
                        'currency',
                        'balance',
                    ],
                ]);
    }
}
