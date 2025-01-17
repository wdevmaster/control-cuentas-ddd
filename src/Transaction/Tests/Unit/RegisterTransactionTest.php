<?php

namespace Bank\Transaction\Tests\Unit;

use Bank\Transaction\Domain\Repositories\TransactionRepository;
use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Domain\Entities\Account;
use Bank\Transaction\Domain\Entities\Transaction;

use Bank\Transaction\Application\Actions\RegisterTransaction;
use Bank\Transaction\Application\Actions\TransactionValidator;
use Bank\Account\Application\Actions\GetAccount;

use Bank\Transaction\Application\DTOs\CreateTransactionDTO;
use Bank\Transaction\Application\DTOs\TransactionDTO;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class RegisterTransactionTest extends TestCase
{
    private MockObject $accountRepository;
    private MockObject $transactionRepository;
    private RegisterTransaction $registerTransaction;

    public function setUp(): void
    {
        parent::setUp();

        $this->transactionRepository = $this->createMock(TransactionRepository::class);
        $this->accountRepository = $this->createMock(AccountRepository::class);

        $this->registerTransaction = new RegisterTransaction(
            $this->transactionRepository,
            new TransactionValidator(),
            new GetAccount(
                $this->accountRepository
            )
        );
    }

    public function test_ItRegistersAValidTransaction()
    {
        $accountId = 1;
        $account = Account::create('Test Account', '1234567890', 'USD', 500.00);
        $account->setId($accountId);
        $data = new CreateTransactionDTO($accountId, 'deposit', 100.00, 'Deposit example');

        $this->accountRepository
            ->expects($this->once())
            ->method('findById')
            ->with($accountId)
            ->willReturn($account);

        $this->transactionRepository
            ->expects($this->once())
            ->method('save')
            ->willReturnCallback(function (Transaction $transaction) {
                $transaction->setId(1);
                return $transaction;
            });

        $result = $this->registerTransaction->execute($data);

        $this->assertInstanceOf(TransactionDTO::class, $result);
        $this->assertEquals('deposit', $result->getType());
        $this->assertEquals(100.00, $result->getAmount());
        $this->assertEquals('Deposit example', $result->getDescription());
    }


}
