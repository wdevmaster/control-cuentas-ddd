<?php

namespace Bank\Transaction\Application\Actions;

use Bank\Transaction\Domain\Repositories\TransactionRepository;
use Bank\Transaction\Domain\Entities\Transaction;

use Bank\Transaction\Application\Actions\TransactionValidator;
use Bank\Transaction\Application\DTOs\TransactionDTO;
use Bank\Transaction\Application\DTOs\CreateTransactionDTO;

use Bank\Account\Application\Actions\GetAccount;

class RegisterTransaction
{
    public function __construct(
        private TransactionRepository $transactionRepository,
        private TransactionValidator $transactionValidator,
        private GetAccount $getAccount
    ) {}

    public function execute(CreateTransactionDTO $data): TransactionDTO
    {
        $account = $this->getAccount->execute($data->getAccountId());

        $this->transactionValidator->execute($account, $data);

        $transaction = Transaction::create(
            $account->getId(),
            $data->getType(),
            $data->getAmount(),
            $data->getDescription()
        );

        $transaction = $this->transactionRepository->save($transaction);

        return TransactionDTO::fromEntity($transaction);
    }

}
