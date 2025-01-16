<?php

namespace Bank\Account\Application\Actions;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Domain\Entities\Account;

class DeleteAccount
{
    public function __construct(
        private AccountRepository $accountRepository
    ){}

    /**
     * Executes the action of deleting an account.
     *
     * @param int $id ID of the account to delete.
     * @return bool True if the account was successfully deleted, false otherwise.
     * @throws \Exception If the account does not exist.
     */
    public function execute(int $id): bool
    {
        $this->existingAccount($id);

        return $this->accountRepository->delete($id);
    }

    /**
     * Checks if the account exists.
     *
     * @param int $id ID of the account to check.
     * @throws \Exception If the account does not exist.
     */
    private function existingAccount(int $id): void
    {
        $account = $this->accountRepository->findById($id);
        if (!$account) {
            throw new \Exception("The account does not exist.");
        }
    }
}
