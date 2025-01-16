<?php

namespace Bank\Account\Infrastructure\Persistence\Eloquent;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Domain\Entities\Account;
use Bank\Account\Domain\ValueObjects\AccountNumber;
use Bank\Account\Domain\ValueObjects\Currency;
use Bank\Account\Domain\ValueObjects\Balance;

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
    {
        try {
            $model = EloquentAccount::findOrFail($id);
            return $this->mapToDomain($model);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    /**
     * Finds an account by its account number.
     *
     * @param string $accountNumber The account number.
     * @return Account|null The account if found, null otherwise.
     */
    public function findByAccountNumber(string $accountNumber): ?Account
    {
        try {
            $model = EloquentAccount::where('account_number', $accountNumber)->firstOrFail();
            return $this->mapToDomain($model);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    /**
     * Finds accounts with pagination.
     *
     * @param int $offset The offset of the first account to return.
     * @param int $limit The maximum number of accounts to return.
     * @return array An array of accounts.
     */
    public function findPaginated(int $offset, int $limit): array
    {
        $models = EloquentAccount::offset($offset)->limit($limit)->get();
        return $models->map(function ($model) {
            return $this->mapToDomain($model);
        })->all();
    }

    /**
     * Counts all accounts.
     *
     * @return int The total number of accounts.
     */
    public function countAll(): int
    {
        return EloquentAccount::count();
    }

    /**
     * Saves an account.
     *
     * @param Account $account The account to save.
     * @return Account The saved account.
     */
    public function save(Account $account): Account
    {
        if ($account->getId() === null) {
            $model = new EloquentAccount();
        } else {
            $model = EloquentAccount::findOrFail($account->getId());
        }

        $model->account_name = $account->getAccountName();
        $model->account_number = $account->getAccountNumber()->getValue();
        $model->currency = $account->getCurrency()->getValue();
        $model->balance = $account->getBalance()->getValue();

        $model->save();

        return $this->mapToDomain($model);
    }

    /**
     * Deletes an account by its ID.
     *
     * @param int $id The ID of the account to delete.
     * @return bool True if the account was deleted, false otherwise.
     */
    public function delete(int $id): bool
    {
        try {
            $model = EloquentAccount::findOrFail($id);
            $model->delete();
            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * Maps an Eloquent model to a domain entity.
     *
     * @param EloquentAccount $model The Eloquent model to map.
     * @return Account The mapped domain entity.
     */
    private function mapToDomain($model): Account
    {
        return new Account(
            $model->account_name,
            new AccountNumber($model->account_number),
            new Currency($model->currency),
            new Balance($model->balance),
            $model->id
        );
    }
}
