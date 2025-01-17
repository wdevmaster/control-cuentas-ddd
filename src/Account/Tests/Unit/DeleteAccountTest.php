<?php

namespace Bank\Account\Tests\Unit;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Domain\Exceptions\AccountNotFoundException;
use Bank\Account\Domain\Entities\Account;

use Bank\Account\Application\Actions\DeleteAccount;
use Bank\Account\Application\Actions\FindAccount;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class DeleteAccountTest extends TestCase
{
    private MockObject $accountRepository;
    private DeleteAccount $deleteAccount;

    protected function setUp(): void
    {
        parent::setUp();

        $this->accountRepository = $this->createMock(AccountRepository::class);
        $this->deleteAccount = new DeleteAccount(
            $this->accountRepository,
            new FindAccount(
                $this->accountRepository,
            )
        );
    }

    public function test_DeletesAccountSuccessfully(): void
    {
        $id = 1;
        $account = Account::create('John D.', '1234567890', 'USD', 1000);
        $account->setId($id);

        $this->accountRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($account);

        $this->accountRepository
            ->expects($this->once())
            ->method('delete')
            ->with($id)
            ->willReturn(true);

        $result = $this->deleteAccount->execute($id);

        $this->assertTrue($result);
    }

    public function test_ThrowsExceptionIfAccountDoesNotExist(): void
    {
        $this->expectException(AccountNotFoundException::class);

        $id = 1;

        $this->accountRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $this->deleteAccount->execute($id);
    }
}
