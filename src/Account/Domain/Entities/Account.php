<?php

namespace Bank\Account\Domain\Entities;

use Bank\Account\Domain\ValueObjects\AccountNumber;
use Bank\Account\Domain\ValueObjects\Currency;
use Bank\Account\Domain\ValueObjects\Balance;

class Account
{
    public function __construct(
        private string $accountName,
        private AccountNumber $accountNumber,
        private Currency $currency,
        private Balance $balance,
        private ?string $id = null,
    ){}

    /**
     * Creates a new instance of Account.
     *
     * @param string $accountName Name of the account.
     * @param string $accountNumber Account number.
     * @param string $currency Currency of the account.
     * @param float $balance Balance of the account.
     * @return self
     */
    public static function create(
        string $accountName,
        string $accountNumber,
        string $currency,
        float $balance
    ) : self {

        return new self(
            $accountName,
            AccountNumber::create($accountNumber),
            Currency::create($currency),
            Balance::create($balance),
        );
    }

    /**
     * Gets the unique identifier of the account.
     *
     * @return ?string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set the ID of the account.
     *
     * @param string $id The ID to set.
     * @return void
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Get the name of the account.
     *
     * @return string The name of the account.
     */
    public function getAccountName(): string
    {
        return $this->accountName;
    }

    /**
     * Set the name of the account.
     *
     * @param string $accountName The name to set.
     * @return void
     */
    public function setAccountName(string $accountName): void
    {
        $this->accountName = $accountName;
    }

    /**
     * Get the account number.
     *
     * @return AccountNumber The account number.
     */
    public function getAccountNumber(): AccountNumber
    {
        return $this->accountNumber;
    }

    /**
     * Get the currency of the account.
     *
     * @return Currency The currency of the account.
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * Get the balance of the account.
     *
     * @return Balance The balance of the account.
     */
    public function getBalance(): Balance
    {
        return $this->balance;
    }
}
