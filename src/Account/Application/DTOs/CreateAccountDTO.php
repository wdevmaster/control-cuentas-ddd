<?php

namespace Bank\Account\Application\DTOs;

class CreateAccountDTO
{

    public function __construct(
        private string $accountName,
        private string $accountNumber,
        private string $currency,
        private float $balance
    ) {}

    /**
     * This function returns the account name.
     *
     * @return string The account name.
     */
    public function getAccountName(): string
    {
        return $this->accountName;
    }

    /**
     * Retrieves the account number.
     *
     * @return string The account number.
     */
    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    /**
     * Retrieves the currency in English.
     *
     * @return string The currency in English.
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Retrieves the balance for a given account.
     *
     * @return float The current balance of the account.
     */
    public function getBalance(): float
    {
        return $this->balance;
    }
}
