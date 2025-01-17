<?php

namespace Bank\Account\Application\Actions;

use Bank\Account\Domain\Repositories\AccountRepository;

use Bank\Account\Application\Actions\FindAccount;

use Bank\Transaction\Application\DTOs\TransactionDTO;

class UpdateAccountBalance
{
    public function __construct(
        private AccountRepository $accountRepository,
        private FindAccount $findAccount
    ){}

    public function execute(TransactionDTO $transaction): void
    {
        $operation = $transaction->getType();
        $account = $this->findAccount->execute($transaction->getAccountId());

        if ($operation === 'deposit') {
            $account->deposit($transaction->getAmount());
        } elseif ($operation === 'withdrawal') {
            $account->withdraw($transaction->getAmount());
        }

        $this->accountRepository->save($account);
    }

}
