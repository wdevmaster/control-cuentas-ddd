<?php

namespace Bank\Account\Application\Actions;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Domain\Entities\Account;

use Bank\Account\Application\DTOs\BankAccountDTO;

class UpdateAccountName
{
    public function __construct(
        private AccountRepository $accountRepository
    ){}

    /**
     * Execute the action of updating the account name.
     *
     * @param int $id The ID of the account to update.
     * @param string $name The new name for the account.
     * @return BankAccountDTO The updated account data transfer object.
     * @throws AccountNotFoundException If the account does not exist.
     * @throws \InvalidArgumentException If the account name is invalid.
     */
    public function execute(int $id, string $name): BankAccountDTO
    {
        $this->validateAccountName($name);
        $account = $this->existingAccount($id);

        $account->setAccountName($name);

        $account = $this->accountRepository->save($account);

        return BankAccountDTO::fromEntity($account);
    }

    /**
     * Retrieve the existing account by ID.
     *
     * @param int $id The ID of the account to retrieve.
     * @return Account The account entity.
     * @throws AccountNotFoundException If the account does not exist.
     */
    private function existingAccount(int $id): Account
    {
        $account = $this->accountRepository->findById($id);
        if (!$account) {
            throw new \Exception("The account does not exist.");
        }

        return $account;
    }

    /**
     * Validate the account name.
     *
     * @param string $name The account name to validate.
     * @throws \InvalidArgumentException If the account name is invalid.
     */
    private function validateAccountName(string $name): void
    {
        if (empty($name) || strlen($name) < 3 || strlen($name) > 50) {
            throw new \InvalidArgumentException("The account name must be between 3 and 50 characters.");
        }
    }
}
