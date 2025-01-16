<?php

namespace Bank\Account\Tests\Unit;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Application\Actions\ListPaginatedAccounts;

use Bank\Account\Application\DTOs\PaginatedAccountsDTO;
use Bank\Account\Application\DTOs\BankAccountDTO;
use Bank\Account\Domain\Entities\Account;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;


class ListPaginatedAccountsTest extends TestCase
{
    private MockObject $accountRepository;
    private ListPaginatedAccounts $listPaginatedAccounts;

    protected function setUp(): void
    {
        parent::setUp();

        $this->accountRepository = $this->createMock(AccountRepository::class);
        $this->listPaginatedAccounts = new ListPaginatedAccounts(
            $this->accountRepository
        );
    }

    public function setUpDataAccounts()
    {
        $accounts = [];
        for ($i=1; $i <= 15; $i++) {
            $accountNumber = str_pad((string)rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
            $balance = round(rand(100, 10000) / 100, 2);

            $account = Account::create('John Doe', $accountNumber, 'USD', $balance);
            $account->setId($i);

            $accounts[] = $account;
        }

        return $accounts;
    }

    public function test_ExecuteSuccessfully()
    {
        $page = 1;
        $pageSize = 5;
        $offset = ($page - 1) * $pageSize;
        $accounts = $this->setUpDataAccounts();
        $totalItems = count($accounts);

        $this->accountRepository
            ->expects($this->once())
            ->method('findPaginated')
            ->with($offset, $pageSize)
            ->willReturn(array_slice($accounts, 0, 5));

        $this->accountRepository
            ->expects($this->once())
            ->method('countAll')
            ->willReturn($totalItems);

        $result = $this->listPaginatedAccounts->execute($page, $pageSize);

        $this->assertInstanceOf(PaginatedAccountsDTO::class, $result);
        $this->assertEquals($page, $result->getPage());
        $this->assertEquals($pageSize, $result->getPageSize());
        $this->assertEquals($totalItems, $result->getTotalItems());
    }

    public function test_ValidatePaginated_ThrowsExceptionForInvalidPage()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Page and page size must be positive integers.');

        $this->listPaginatedAccounts->execute(0, 10);
    }

    public function test_ValidatePaginated_ThrowsExceptionForInvalidPageSize()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Page and page size must be positive integers.');

        $this->listPaginatedAccounts->execute(1, 0);
    }

    public function test_Execute_ThrowsExceptionWhenFetchingFails()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error fetching paginated accounts');

        $page = 1;
        $pageSize = 10;
        $offset = ($page - 1) * $pageSize;

        $this->accountRepository
            ->expects($this->once())
            ->method('findPaginated')
            ->with($offset, $pageSize)
            ->willThrowException(new \Exception('Database error'));

        $this->listPaginatedAccounts->execute($page, $pageSize);
    }
}
