<?php

namespace Bank\Transaction\Tests\Feature;

use Bank\Transaction\Infrastructure\Persistence\Models\EloquentTransaction;
use Bank\Account\Infrastructure\Persistence\Models\EloquentAccount;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionControllerStoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function setUpDataAccounts()
    {
        $accountNumber = str_pad((string)rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
        $balance = round(rand(100, 10000) / 100, 2);

        return EloquentAccount::create([
            'account_number' => $accountNumber,
            'account_name' => 'John Doe',
            'currency' => 'USD',
            'balance' => $balance
        ]);
    }

    public function test_ItShouldStoreANewTransactionSuccessfully()
    {
        $account = $this->setUpDataAccounts();
        $data = [
            'accountId' => $account->id,
            'type' => 'deposit',
            'amount' => 200,
            'description' => 'Initial deposit',
        ];

        $response = $this->postJson('/api/transactions', $data);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Transaction processed successfully',
        ]);
    }

    public function test_ItShouldReturnValidationErrorForMissinFields()
    {
        $response = $this->postJson('/api/transactions', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['accountId', 'type', 'amount']);
    }

    public function test_ItShouldReturnValidationErrorForInvalidAmount()
    {
        $data = [
            'accountId' => 1,
            'type' => 'deposit',
            'amount' => -100,
            'description' => 'Invalid amount transaction',
        ];

        $response = $this->postJson('/api/transactions', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['amount']);

    }

}
