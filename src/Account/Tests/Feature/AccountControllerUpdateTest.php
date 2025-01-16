<?php

namespace Bank\Account\Tests\Feature;

use Bank\Account\Infrastructure\Persistence\Models\EloquentAccount;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountControllerUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_UpdateWithValidData()
    {
        $account = EloquentAccount::create([
            'account_number' => '1234567890',
            'account_name' => 'John Doe',
            'currency' => 'USD',
            'balance' => 1000,
        ]);

        $data = [
            'accountName' => 'Updated Account Name',
        ];

        $response = $this->putJson('/api/accounts/' . $account->id, $data);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'id',
                     'accountNumber',
                     'accountName',
                     'currency',
                     'balance'
                 ]);

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'account_name' => 'Updated Account Name',
        ]);
    }


    public function test_UpdateWithInvalidData()
    {
        $account = EloquentAccount::create([
            'account_number' => '1234567890',
            'account_name' => 'John Doe',
            'currency' => 'USD',
            'balance' => 1000,
        ]);

        $data = [
            'accountName' => '',
        ];

        $response = $this->putJson('/api/accounts/' . $account->id, $data);

        $response->assertStatus(422)
                 ->assertJsonStructure([
                     'errors' => [
                         'accountName',
                     ],
                 ]);
    }

    public function test_UpdateWithNonExistingId()
    {
        $data = [
            'accountName' => 'Updated Account Name',
        ];

        $response = $this->putJson('/api/accounts/999999', $data);

        $response->assertStatus(404)
                 ->assertJson([
                     'error' => 'Account not found',
                 ]);
    }
}
