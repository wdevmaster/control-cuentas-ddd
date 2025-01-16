<?php

namespace Bank\Account\Domain\ValueObjects;

class AccountNumber
{
    public function __construct(
        private string $value
    ){}

    /**
     * Creates a new instance of AccountNumber.
     *
     * @param string $value The account number value.
     * @return self
     * @throws \InvalidArgumentException If the account number format is invalid.
     */
    public static function create(string $value): self
    {
        self::ensureIsValidAccountNumber($value);
        return new self($value);
    }

    /**
     * Checks if the account number is valid.
     *
     * @param string $value The account number value.
     * @throws \InvalidArgumentException If the account number format is invalid.
     */
    private static function ensureIsValidAccountNumber(string $value): void
    {
        if (!preg_match('/^\d{10}$/', $value)) {
            throw new \InvalidArgumentException('Invalid account number format.');
        }
    }

    /**
     * Gets the value of the account number.
     *
     * @return string The value of the account number.
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
