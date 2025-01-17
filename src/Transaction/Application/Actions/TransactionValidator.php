<?php

namespace Bank\Transaction\Application\Actions;

use Bank\Transaction\Domain\ValueObjects\Type;
use Bank\Transaction\Domain\ValueObjects\Amount;
use Bank\Transaction\Domain\Exceptions\InsufficientBalanceException;

use Bank\Transaction\Application\DTOs\CreateTransactionDTO;
use Bank\Account\Application\DTOs\AccountDTO;

class TransactionValidator
{
    public function execute(AccountDTO $account, CreateTransactionDTO $data): void
    {
        $type = Type::create($data->getType());
        $amount = Amount::create($data->getAmount());

        if ($type->isWithdrawal() && $account->getBalance() < $amount->getValue()) {
            throw new InsufficientBalanceException();
        }
    }
}
