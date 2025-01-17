<?php

namespace Bank\Account\Application\Actions;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Domain\Entities\Account;

use Bank\Account\Application\DTOs\CreateAccountDTO;
use Bank\Account\Application\DTOs\AccountDTO;

class CreateAccount
{
    public function __construct(
        private AccountRepository $accountRepository
    ){}

    /**
     * Executes the creation of a new account.
     *
     * @param CreateAccountDTO $data
     * @return AccountDTO
     * @throws \Exception if the account number is already in use or the balance is invalid.
     */
    public function execute(CreateAccountDTO $data): AccountDTO
    {
        $this->existingAccount($data->getAccountNumber());
        $this->validateBalance($data->getBalance());

        $account = Account::create(
            $data->getAccountName(),
            $data->getAccountNumber(),
            $data->getCurrency(),
            $data->getBalance()
        );

        $account = $this->accountRepository->save($account);

        return AccountDTO::fromEntity($account);
    }

    /**
     * Checks if an account with the given account number already exists.
     *
     * @param string $accountNumber
     * @throws \Exception if the account number is already in use.
     */
    private function existingAccount(string $accountNumber): void
    {
        $account = $this->accountRepository->findByAccountNumber($accountNumber);
        if ($account) {
            throw new \Exception("The account number is already in use.");
        }
    }

    /**
     * Validates the initial balance of the account.
     *
     * @param float $balance
     * @throws \Exception if the balance is invalid.
     */
    private function validateBalance(float $balance): void
    {
        if ($balance < 0) {
            throw new \InvalidArgumentException("The balance must be greater than 0.");
        }
    }
}
