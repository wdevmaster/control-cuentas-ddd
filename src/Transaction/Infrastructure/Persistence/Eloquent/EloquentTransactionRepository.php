<?php

namespace Bank\Transaction\Infrastructure\Persistence\Eloquent;

use Bank\Transaction\Domain\Entities\Transaction;
use Bank\Transaction\Domain\Repositories\TransactionRepository;

use Bank\Transaction\Infrastructure\Persistence\Models\EloquentTransaction;

class EloquentTransactionRepository implements TransactionRepository
{
    /**
     * Save a transaction
     *
     * @param Transaction $transaction The transaction to save.
     * @return void
     */
    public function save(Transaction $transaction): void
    {}

    /**
     * Find transactions by account ID
     *
     * @param string $accountId The account ID to search.
     * @return array The list of transactions found.
     */
    public function findByAccountId(string $accountId): array
    {
        return [];
    }
}
