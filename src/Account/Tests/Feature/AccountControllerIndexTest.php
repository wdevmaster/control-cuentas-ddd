<?php

namespace Bank\Account\Tests\Feature;

use Bank\Account\Infrastructure\Persistence\Models\EloquentAccount;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountControllerIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function setUpDataAccounts()
    {
        for ($i=1; $i <= 15; $i++) {
            $accountNumber = str_pad((string)rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
            $balance = round(rand(100, 10000) / 100, 2);

            EloquentAccount::create([
                'account_number' => $accountNumber,
                'account_name' => 'John Doe',
                'currency' => 'USD',
                'balance' => $balance
            ]);
        }
    }

    public function test_ItCanListPaginatedAccounts()
    {
        $this->setUpDataAccounts();

        $response = $this->get('/api/accounts?page=1&pageSize=10');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data',
            'currentPage',
            'perPage',
            'total',
            'lastPage',
        ]);

        $response->assertJsonCount(10, 'data');
    }


    public function test_ItReturns400IfPageIsNotNumeric()
    {
        $response = $this->get('/api/accounts?page=invalid&pageSize=10');

        $response->assertStatus(400);
    }

    public function test_ItReturns400IfPageIsLessThan1()
    {
        $response = $this->get('/api/accounts?page=0&pageSize=10');

        $response->assertStatus(400);
    }

}
