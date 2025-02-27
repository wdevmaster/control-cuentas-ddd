<?php

namespace Bank\Account\Tests\Unit;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Domain\Exceptions\AccountNotFoundException;
use Bank\Account\Domain\Entities\Account;

use Bank\Account\Application\Actions\UpdateAccountName;
use Bank\Account\Application\Actions\FindAccount;
use Bank\Account\Application\DTOs\AccountDTO;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class UpdateAccountNameTest extends TestCase
{
    private MockObject $accountRepository;
    private UpdateAccountName $updateAccountName;

    public function setUp(): void
    {
        parent::setUp();

        $this->accountRepository = $this->createMock(AccountRepository::class);

        $this->updateAccountName = new UpdateAccountName(
            $this->accountRepository,
            new FindAccount(
                $this->accountRepository
            )
        );
    }

    public function test_UpdatesAccountNameSuccessfully()
    {
        $id = 1;
        $newName = 'Jane Doe';
        $account = Account::create('John D.', '1234567890', 'USD', 1000);
        $account->setId($id);

        $this->accountRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($account);

        $account->setAccountName($newName);
        $this->accountRepository
            ->expects($this->once())
            ->method('save')
            ->with($account)
            ->willReturn($account);


        $result = $this->updateAccountName->execute($id, $newName);

        $this->assertInstanceOf(AccountDTO::class, $result);

    }

    public function test_ThrowsExceptionIfAccountDoesNotExist()
    {
        $this->expectException(AccountNotFoundException::class);

        $id = 1;
        $newName = 'Jane Doe';

        $this->accountRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $this->updateAccountName->execute($id, $newName);
    }
}
