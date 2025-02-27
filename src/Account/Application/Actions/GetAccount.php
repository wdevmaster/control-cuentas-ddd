<?php

namespace Bank\Account\Application\Actions;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Domain\Exceptions\AccountNotFoundException;

use Bank\Account\Application\DTOs\AccountDTO;

class GetAccount
{
    public function __construct(
        private AccountRepository $accountRepository
    ){}

    /**
     * Retrieves a bank account and converts it to a DTO.
     *
     * @param Account $account The account entity to be converted.
     * @return AccountDTO The DTO representation of the account.
     * @throws AccountNotFoundException if the account does not exist.
     */
    public function execute(int $id): AccountDTO
    {
        $account = $this->accountRepository->findById($id);

        if (!$account) {
            throw new AccountNotFoundException();
        }

        return AccountDTO::fromEntity($account);
    }
}
