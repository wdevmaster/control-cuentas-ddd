<?php

namespace Bank\Account\Application\Actions;

use Bank\Account\Domain\Repositories\AccountRepository;

use Bank\Account\Application\DTOs\BankAccountDTO;

class GetAccount
{
    public function __construct(
        private AccountRepository $accountRepository
    ){}

    /**
     * Retrieves a bank account and converts it to a DTO.
     *
     * @param Account $account The account entity to be converted.
     * @return BankAccountDTO The DTO representation of the account.
     */
    public function execute(int $id): BankAccountDTO
    {
        $account = $this->accountRepository->findById($id);

        if (!$account) {
            throw new \Exception("The account does not exist.");
        }

        return BankAccountDTO::fromEntity($account);
    }
}
