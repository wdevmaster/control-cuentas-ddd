<?php

namespace Bank\Account\Infrastructure\Persistence\Eloquent;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Domain\Entities\Account;

use Bank\Account\Infrastructure\Persistence\Models\EloquentAccount;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentAccountRepository implements AccountRepository
{
    /**
     * Finds an account by its ID.
     *
     * @param int $id The ID of the account.
     * @return Account|null The account if found, null otherwise.
     */
    public function findById(int $id): ?Account
    {}

    /**
     * Finds an account by its account number.
     *
     * @param string $accountNumber The account number.
     * @return Account|null The account if found, null otherwise.
     */
    public function findByAccountNumber(string $accountNumber): ?Account
    {}

    /**
     * Finds accounts with pagination.
     *
     * @param int $offset The offset of the first account to return.
     * @param int $limit The maximum number of accounts to return.
     * @return array An array of accounts.
     */
    public function findPaginated(int $offset, int $limit): array
    {}

    /**
     * Counts all accounts.
     *
     * @return int The total number of accounts.
     */
    public function countAll(): int
    {}

    /**
     * Saves an account.
     *
     * @param Account $account The account to save.
     * @return Account The saved account.
     */
    public function save(Account $account): Account
    {}

    /**
     * Deletes an account by its ID.
     *
     * @param int $id The ID of the account to delete.
     * @return bool True if the account was deleted, false otherwise.
     */
    public function delete(int $id): bool
    {}

    /**
     * Maps an Eloquent model to a domain entity.
     *
     * @param EloquentAccount $model The Eloquent model to map.
     * @return Account The mapped domain entity.
     */
    private function mapToDomain($model): Account
    {}
}
