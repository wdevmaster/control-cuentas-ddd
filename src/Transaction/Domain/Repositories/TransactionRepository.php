<?php

namespace Bank\Transaction\Domain\Repositories;

use Bank\Transaction\Domain\Entities\Transaction;

interface TransactionRepository
{
    public function save(Transaction $transaction): Transaction;

    public function findByAccountId(int $accountId): array;
}
