<?php

namespace Bank\Account\Tests\Feature;

use Bank\Account\Infrastructure\Persistence\Models\EloquentAccount;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountControllerDestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_ItCanDeleteAnAccount()
    {
        $account = EloquentAccount::create([
            'account_number' => '1234567890',
            'account_name' => 'John Doe',
            'currency' => 'USD',
            'balance' => 1000,
        ]);

        $response = $this->delete('/api/accounts/' . $account->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('accounts', ['id' => $account->id]);
    }

    public function test_ItReturns404IfAccountNotFound()
    {
        $response = $this->delete('/api/accounts/' . 999);

        $response->assertStatus(404);
    }
}
