<?php

namespace Bank\Account\Application\Actions;

use Bank\Account\Domain\Repositories\AccountRepository;

class DeleteAccount
{
    public function __construct(
        private AccountRepository $accountRepository,
        private FindAccount $findAccount
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
        $this->findAccount->execute($id);

        return $this->accountRepository->delete($id);
    }
}
