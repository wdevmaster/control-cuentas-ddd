<?php

namespace Bank\Transaction\Domain\ValueObjects;

class Amount
{
    public function __construct(
        private float $value
    ){}

    /**
     * Create a new Amount instance
     *
     * @param float $value The amount value to set.
     * @return self A new instance of Amount.
     * @throws InvalidArgumentException if the amount value is not valid.
     */
    public static function create(float $value): self
    {
        self::ensureIsValidAmount($value);
        return new self($value);
    }

    /**
     * Ensure the amount value is valid
     *
     * @param float $value The amount value to validate.
     * @throws InvalidArgumentException if the amount value is not valid.
     */
    private static function ensureIsValidAmount(float $value): void
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException(sprintf('Invalid amount <%s>', $value));
        }
    }

    /**
     * Get the amount value
     *
     * @return float The amount value.
     */
    public function getValue(): float
    {
        return $this->value;
    }
}
