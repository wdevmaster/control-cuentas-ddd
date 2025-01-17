<?php

namespace Bank\Account\Tests\Unit;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Domain\Entities\Account;

use Bank\Account\Application\Actions\UpdateAccountBalance;
use Bank\Account\Application\Actions\FindAccount;

use Bank\Transaction\Application\DTOs\TransactionDTO;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class UpdateAccountBalanceTest extends TestCase
{
    private MockObject $accountRepository;
    private UpdateAccountBalance $updateAccountBalance;

    public function setUp(): void
    {
        parent::setUp();

        $this->accountRepository = $this->createMock(AccountRepository::class);

        $this->updateAccountBalance = new UpdateAccountBalance(
            $this->accountRepository,
            new FindAccount(
                $this->accountRepository
            )
        );
    }

    public function test_ItShouldDepositAmountToAccount()
    {
        $id = 1;
        $account = Account::create('Savings', '1234567890', 'USD', 1000);
        $account->setId($id);
        $transaction = new TransactionDTO(1, $id, 'deposit', 100, 'Deposit transaction', now());

        $this->accountRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($account);

        $account->deposit($transaction->getAmount());
        $this->accountRepository
            ->expects($this->once())
            ->method('save')
            ->with($account)
            ->willReturn($account);

        $this->updateAccountBalance->execute($transaction);
    }

    public function test_ItShouldWithdrawAmountFromAccount()
    {
        $id = 1;
        $account = Account::create('Savings', '1234567890', 'USD', 1000);
        $account->setId($id);
        $transaction = new TransactionDTO(1, $id, 'withdrawal', 100, 'Withdrawal transaction', now());

        $this->accountRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($account);

        $account->withdraw($transaction->getAmount());
        $this->accountRepository
            ->expects($this->once())
            ->method('save')
            ->with($account)
            ->willReturn($account);

        $this->updateAccountBalance->execute($transaction);
    }
}
