<?php

namespace Bank\Account\Application\Actions;

use Bank\Account\Domain\Repositories\AccountRepository;

use Bank\Account\Application\DTOs\PaginatedAccountsDTO;
use Bank\Account\Application\DTOs\BankAccountDTO;

class ListPaginatedAccounts
{
    public function __construct(
        private AccountRepository $accountRepository
    ){}

    /**
     * Executes the action of listing paginated accounts.
     *
     * @param int $page Current page number.
     * @param int $pageSize Size of the page.
     * @return PaginatedAccountsDTO DTO object with the paginated accounts.
     * @throws \Exception If an error occurs while fetching the accounts.
     */
    public function execute(int $page = 1, int $pageSize = 10): PaginatedAccountsDTO
    {
        $this->validatePaginated($page, $pageSize);

        $offset = ($page - 1) * $pageSize;

        try {
            $accounts = $this->accountRepository->findPaginated($offset, $pageSize);
            $totalItems = $this->accountRepository->countAll();
        } catch (\Exception $e) {
            throw new \Exception('Error fetching paginated accounts', 0, $e);
        }

        $accounts = $this->mapAccounts($accounts);

        return new PaginatedAccountsDTO($accounts, $page, $pageSize, $totalItems);
    }

    /**
     * Validates the pagination parameters.
     *
     * @param int $page Page number.
     * @param int $pageSize Page size.
     * @throws \InvalidArgumentException If the parameters are not valid.
     */
    private function validatePaginated($page, $pageSize): void
    {
        if ($page < 1 || $pageSize < 1) {
            throw new \InvalidArgumentException('Page and page size must be positive integers.');
        }
    }

    /**
     * Maps a list of account entities to an array of account DTOs.
     *
     * @param array $accounts List of account entities.
     * @return array Array of account DTOs.
     */
    private function mapAccounts($accounts): array
    {
        return array_map(function($account) {
            return BankAccountDTO::fromEntity($account)->toArray();
        }, $accounts);
    }
}
