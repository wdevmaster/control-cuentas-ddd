<?php

namespace Bank\Account\Tests\Feature;

use Bank\Account\Infrastructure\Persistence\Models\EloquentAccount;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountControllerShowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_ShowWithValidId()
    {
        $account = EloquentAccount::create([
            'account_number' => '1234567890',
            'account_name' => 'John Doe',
            'currency' => 'USD',
            'balance' => 1000,
        ]);

        $response = $this->getJson('/api/accounts/' . $account->id);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'account' => [
                        'id',
                        'account_number',
                        'account_name',
                        'currency',
                        'balance',
                    ],
                    'transactions',
                ]);
    }

    public function testShowWithInvalidId()
    {
        $response = $this->getJson('/api/accounts/999999');

        $response->assertStatus(404)
                 ->assertJson([
                     'error' => 'Account not found',
                 ]);
    }
}
