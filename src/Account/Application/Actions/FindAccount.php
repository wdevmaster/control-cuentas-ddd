<?php

namespace Bank\Account\Application\Actions;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Domain\Exceptions\AccountNotFoundException;
use Bank\Account\Domain\Entities\Account;

class FindAccount
{
    public function __construct(
        private AccountRepository $accountRepository
    ){}

    /**
     * Retrieve the existing account by ID.
     *
     * @param int $id The ID of the account to retrieve.
     * @return Account The account entity.
     * @throws AccountNotFoundException If the account does not exist.
     */
    public function execute(int $id): Account
    {
        $account = $this->accountRepository->findById($id);
        if (!$account) {
            throw new AccountNotFoundException();
        }

        return $account;
    }
}
