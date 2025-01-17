<?php

namespace Bank\Transaction\Application\Actions;

use Bank\Transaction\Domain\Repositories\TransactionRepository;

use Bank\Transaction\Application\DTOs\TransactionDTO;

class GetAccountTransactions
{
    public function __construct(
        private TransactionRepository $transactionRepository
    ) {}

    public function execute(int $accountId): array
    {
        $transactions = $this->transactionRepository->findByAccountId($accountId);

        return array_map(function ($transaction) {
            return TransactionDTO::fromEntity($transaction);
        }, $transactions);
    }
}
