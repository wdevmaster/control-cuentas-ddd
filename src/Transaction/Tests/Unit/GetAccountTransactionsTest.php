<?php

namespace Bank\Transaction\Tests\Unit;

use Bank\Transaction\Domain\Repositories\TransactionRepository;
use Bank\Transaction\Domain\Entities\Transaction;
use Bank\Transaction\Domain\ValueObjects\Type;
use Bank\Transaction\Domain\ValueObjects\Amount;

use Bank\Transaction\Application\Actions\GetAccountTransactions;
use Bank\Transaction\Application\DTOs\TransactionDTO;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class GetAccountTransactionsTest extends TestCase
{
    private MockObject $transactionRepository;
    private GetAccountTransactions $getAccountTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->transactionRepository = $this->createMock(TransactionRepository::class);

        $this->getAccountTransactions = new GetAccountTransactions(
            $this->transactionRepository
        );
    }

    public function test_ItReturnsAListOfTransactionDtos()
    {
        $accountId = 1;
        $transactions = [
            new Transaction($accountId, new Type('deposit'), new Amount(100.0), 'Depósito inicial', new \DateTimeImmutable('2025-01-17 10:00:00'), 1),
            new Transaction($accountId, new Type('withdrawal'), new Amount(50.0), 'Compra en tienda', new \DateTimeImmutable('2025-01-17 12:00:00'), 2),
        ];
        $transaction = TransactionDTO::fromEntity($transactions[0]);

        $this->transactionRepository
            ->method('findByAccountId')
            ->with($accountId)
            ->willReturn($transactions);

        $result = $this->getAccountTransactions->execute($accountId);

        $this->assertCount(count($transactions), $result);
        $this->assertInstanceOf(TransactionDTO::class, $result[0]);

        $this->assertEquals($transaction, $result[0]);
    }

    public function test_ItThrowsAnExceptionIfNoTransactionsFound()
    {
        $accountId = 1;
        $transactions = [];

        $this->transactionRepository
            ->method('findByAccountId')
            ->with($accountId)
            ->willReturn($transactions);

        $result = $this->getAccountTransactions->execute($accountId);

        $this->assertCount(count($transactions), $result);
    }

}
