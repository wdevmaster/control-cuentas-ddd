<?php

namespace Bank\Account\Tests\Unit;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Domain\Entities\Account;

use Bank\Account\Application\Actions\CreateAccount;
use Bank\Account\Application\DTOs\CreateAccountDTO;
use Bank\Account\Application\DTOs\AccountDTO;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CreateAccountTest extends TestCase
{
    private MockObject $accountRepository;
    private CreateAccount $createAccount;

    public function setUp(): void
    {
        parent::setUp();

        $this->accountRepository = $this->createMock(AccountRepository::class);

        $this->createAccount = new CreateAccount(
            $this->accountRepository
        );
    }

    public function test_ExecuteCreatesAccountSuccessfully()
    {
        $id = 1;
        $data = new CreateAccountDTO('John Doe', '1234567890', 'USD', 1000);

        $this->accountRepository
            ->expects($this->once())
            ->method('findByAccountNumber')
            ->with($data->getAccountNumber())
            ->willReturn(null);

        $this->accountRepository
            ->expects($this->once())
            ->method('save')
            ->willReturnCallback(function (Account $account) use ($id) {
                $account->setId($id);
                return $account;
            });


        $result = $this->createAccount->execute($data);

        $this->assertInstanceOf(AccountDTO::class, $result);
        $this->assertEquals([
            'id' => $id,
            'accountName' => $data->getAccountName(),
            'accountNumber' => $data->getAccountNumber(),
            'currency' => $data->getCurrency(),
            'balance' => $data->getBalance(),
        ], $result->toArray());
    }

    public function testExecuteThrowsExceptionIfAccountNumberExists()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('The account number is already in use.');

        $data = new CreateAccountDTO('John Doe', '123456789', 'USD', 1000);

        $existingAccount = $this->createMock(Account::class);

        $this->accountRepository->expects($this->once())
            ->method('findByAccountNumber')
            ->with($data->getAccountNumber())
            ->willReturn($existingAccount);

        $this->createAccount->execute($data);
    }

    public function testExecuteThrowsExceptionIfBalanceIsInvalid()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The balance must be greater than 0.');

        $data = new CreateAccountDTO('John Doe', '123456789', 'USD', -1000);

        $this->createAccount->execute($data);
    }

}
