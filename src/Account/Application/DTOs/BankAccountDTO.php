<?php

namespace Bank\Account\Application\DTOs;

class BankAccountDTO
{
    public function __construct(
        private int $id,
        private string $accountName,
        private string $accountNumber,
        private string $currency,
        private float $balance,
    ){}
    /**
     * Converts an entity object to a DTO (Data Transfer Object).
     *
     * @param Account $account The entity object to be converted.
     * @return BankAccountDTO The resulting DTO object.
     */
    public static function fromEntity($account): self
    {
        return new self(
            $account->getId(),
            $account->getAccountName(),
            $account->getAccountNumber()->getValue(),
            $account->getCurrency()->getValue(),
            $account->getBalance()->getValue(),
        );
    }

    /**
     * Converts the DTO object into an associative array.
     *
     * @return array The associative array representing the DTO object.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'accountName' => $this->accountName,
            'accountNumber' => $this->accountNumber,
            'currency' => $this->currency,
            'balance' => $this->balance,
        ];
    }
}
