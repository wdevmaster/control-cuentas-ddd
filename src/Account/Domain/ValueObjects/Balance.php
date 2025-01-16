<?php

namespace Bank\Account\Domain\ValueObjects;

use InvalidArgumentException;

class Balance
{

    public function __construct(
        private float $value = 0
    ){}

    /**
     * Create a new Balance instance
     *
     * @param float $value The balance value to set.
     * @return self A new instance of Balance.
     * @throws InvalidArgumentException if the value is not valid.
     */
    public static function create(float $value): self
    {
        self::ensureIsValidvalue($value);
        return new self($value);
    }

    /**
     * Ensure the balance value is valid
     *
     * @param float $value The balance value to validate.
     * @throws InvalidArgumentException if the value is not a number or is less than 0.
     */
    private static function ensureIsValidvalue(float $value): void
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('The balance must be a decimal number.');
        }

        if ($value < 0) {
            throw new InvalidArgumentException('The balance must be at least 0.');
        }
    }

    /**
     * Get the balance value
     *
     * @return float The current balance value.
     */
    public function getValue(): float
    {
        return $this->value;
    }
}
