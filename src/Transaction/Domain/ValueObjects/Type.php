<?php

namespace Bank\Transaction\Domain\ValueObjects;

class Type
{
    private const DEPOSIT = 'deposit';
    private const WITHDRAWAL = 'withdrawal';

    private const AVAILABLE_TYPES = [
        self::DEPOSIT,
        self::WITHDRAWAL,
    ];

    public function __construct(
        private string $value
    ){}

    /**
     * Get the list of available transaction types
     *
     * @return array The list of available transaction types.
     */
    public static function availableTypes(): array
    {
        return self::AVAILABLE_TYPES;
    }
    /**
     * Create a new TransactionType instance
     *
     * @param string $value The transaction type value to set.
     * @return self A new instance of TransactionType.
     * @throws InvalidArgumentException if the transaction type value is not valid.
     */
    public static function create(string $value): self
    {
        self::ensureIsValidType($value);
        return new self($value);
    }

    /**
     * Ensure the transaction type value is valid
     *
     * @param string $value The transaction type value to validate.
     * @throws InvalidArgumentException if the transaction type value is not valid.
     */
    private static function ensureIsValidType(string $value): void
    {
        $allowedValues = [self::DEPOSIT, self::WITHDRAWAL];
        if (!in_array($value, $allowedValues, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid transaction type <%s>', $value));
        }
    }

    /**
    * Check if the transaction type is a withdrawal.
    *
    * @return bool True if the type is withdrawal, false otherwise.
    */
    public function isWithdrawal(): bool
    {
        return $this->value === self::WITHDRAWAL;
    }

   /**
    * Check if the transaction type is a deposit.
    *
    * @return bool True if the type is deposit, false otherwise.
    */
    public function isDeposit(): bool
    {
        return $this->value === self::DEPOSIT;
    }

    /**
     * Get the transaction type value
     *
     * @return string The transaction type value.
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
