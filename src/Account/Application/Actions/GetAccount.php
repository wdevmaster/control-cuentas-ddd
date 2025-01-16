<?php

namespace Bank\Account\Application\Actions;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Domain\Exceptions\AccountNotFoundException;

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
     * @throws AccountNotFoundException if the account does not exist.
     */
    public function execute(int $id): BankAccountDTO
    {
        $account = $this->accountRepository->findById($id);

        if (!$account) {
            throw new AccountNotFoundException();
        }

        return BankAccountDTO::fromEntity($account);
    }
}
