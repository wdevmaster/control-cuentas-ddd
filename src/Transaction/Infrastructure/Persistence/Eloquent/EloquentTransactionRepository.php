<?php

namespace Bank\Transaction\Infrastructure\Persistence\Eloquent;

use Bank\Transaction\Domain\ValueObjects\Type;
use Bank\Transaction\Domain\ValueObjects\Amount;
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
    public function save(Transaction $transaction): Transaction
    {
        if ($transaction->getId() === null) {
            $model = new EloquentTransaction();
        } else {
            $model = EloquentTransaction::findOrFail($transaction->getId());
        }

        $model->account_id = $transaction->getAccountId();
        $model->type = $transaction->getType()->getValue();
        $model->amount = $transaction->getAmount()->getValue();
        $model->description = $transaction->getDescription();
        $model->created_at = $transaction->getCreatedAt()->format('Y-m-d H:i:s');

        $model->save();

        return $this->mapToDomain($model);
    }

    /**
     * Find transactions by account ID
     *
     * @param string $accountId The account ID to search.
     * @return array The list of transactions found.
     */
    public function findByAccountId(int $accountId): array
    {
        $models = EloquentTransaction::where('account_id', $accountId)->get();
        return $models->map(function ($model) {
            return $this->mapToDomain($model);
        })->all();
    }

    /**
     * Maps an Eloquent model to a domain entity.
     *
     * @param EloquentTransaction $model The Eloquent model to map.
     * @return Transaction The mapped domain entity.
     */
    private function mapToDomain($model): Transaction
    {
        return new Transaction(
            $model->account_id,
            new Type($model->type),
            new Amount($model->amount),
            $model->description,
            new \DateTimeImmutable($model->created_at),
            $model->id
        );
    }
}
