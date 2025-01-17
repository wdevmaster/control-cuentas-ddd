<?php

namespace Bank\Transaction\Tests\Unit;

use Bank\Transaction\Domain\Exceptions\InsufficientBalanceException;

use Bank\Transaction\Application\Actions\TransactionValidator;

use Bank\Transaction\Application\DTOs\CreateTransactionDTO;
use Bank\Account\Application\DTOs\AccountDTO;

use PHPUnit\Framework\TestCase;

class TransactionValidatorTest extends TestCase
{
    private TransactionValidator $transactionValidator;

    public function setUp(): void
    {
        parent::setUp();

        $this->transactionValidator = new TransactionValidator();
    }

    public function test_ItAllowsValidDepositTransaction()
    {
        $account = new AccountDTO(1, 'Test Account', '1234567890', 'USD', 100.00);
        $data = new CreateTransactionDTO($account->getId(), 'deposit', 50.00, 'salary');

        $this->transactionValidator->execute($account, $data);

        $this->assertTrue(true);
    }

    public function test_ItAllowsValidWithdrawalTransaction()
    {
        $account = new AccountDTO(1, 'Test Account', '1234567890', 'USD', 100.00);
        $data = new CreateTransactionDTO($account->getId(), 'withdrawal', 50.00, 'salary');

        $this->transactionValidator->execute($account, $data);

        $this->assertTrue(true);
    }

    public function test_ItThrowsExceptionForInsufficientBalanceOnWithdrawal()
    {
        $account = new AccountDTO(1, 'Test Account', '1234567890', 'USD', 100.00);
        $data = new CreateTransactionDTO($account->getId(), 'withdrawal', 150.00, 'buys');

        $this->expectException(InsufficientBalanceException::class);
        $this->transactionValidator->execute($account, $data);
    }

    public function test_ItThrowsExceptionForInvalidTransactionType()
    {
        $account = new AccountDTO(1, 'Test Account', '1234567890', 'USD', 100.00);
        $data = new CreateTransactionDTO($account->getId(), 'invalid_type', 150.00, 'buys');

        $this->expectException(\InvalidArgumentException::class);
        $this->transactionValidator->execute($account, $data);
    }

    public function test_ItThrowsExceptionForInvalidTransactionAmount()
    {
        $account = new AccountDTO(1, 'Test Account', '1234567890', 'USD', 100.00);
        $data = new CreateTransactionDTO($account->getId(), 'deposit', -50.00, 'salary');

        $this->expectException(\InvalidArgumentException::class);
        $this->transactionValidator->execute($account, $data);
    }
}
