<?php

namespace Bank\Account\Tests\Unit;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Domain\Exceptions\AccountNotFoundException;
use Bank\Account\Domain\Entities\Account;

use Bank\Account\Application\Actions\GetAccount;
use Bank\Account\Application\DTOs\BankAccountDTO;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class GetAccountTest extends TestCase
{
    private MockObject $accountRepository;
    private GetAccount $getAccount;

    public function setUp(): void
    {
        parent::setUp();

        $this->accountRepository = $this->createMock(AccountRepository::class);
        $this->getAccount = new GetAccount($this->accountRepository);
    }

    public function test_GetAccountSuccessfully()
    {
        $id = 1;
        $account = Account::create('John Doe', '1234567890', 'USD', 1000);
        $account->setId($id);

        $this->accountRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($account);

        $result = $this->getAccount->execute($id);

        $this->assertInstanceOf(BankAccountDTO::class, $result);
    }

    public function test_ThrowsExceptionIfAccountDoesNotExist()
    {
        $this->expectException(AccountNotFoundException::class);

        $id = 1;

        $this->accountRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $this->getAccount->execute($id);
    }
}
