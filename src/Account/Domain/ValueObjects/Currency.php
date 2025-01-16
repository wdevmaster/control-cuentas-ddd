<?php

namespace Bank\Account\Domain\ValueObjects;

class Currency
{
    private const USD = 'USD';
    private const EUR = 'EUR';
    private const CRC = 'CRC';

    private const AVAILABLE_CURRENCIES = [
        self::USD,
        self::EUR,
        self::CRC,
    ];

    private function __construct(
        private string $value
    ){}

    /**
     * Get the list of available currencies
     *
     * @return array The list of available currencies.
     */
    public static function availableCurrencies(): array
    {
        return self::AVAILABLE_CURRENCIES;
    }

    /**
     * Create a new Currency instance
     *
     * @param string $value The currency value to set.
     * @return self A new instance of Currency.
     * @throws InvalidArgumentException if the currency value is not valid.
     */
    public static function create(string $value): self
    {
        self::ensureIsValidCurrency($value);
        return new self($value);
    }

    /**
     * Ensure the currency value is valid
     *
     * @param string $value The currency value to validate.
     * @throws InvalidArgumentException if the currency value is not valid.
     */
    private static function ensureIsValidCurrency(string $value): void
    {
        $allowedValues = [self::USD, self::EUR, self::CRC];
        if (!in_array($value, $allowedValues, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid currency <%s>', $value));
        }
    }

    /**
     * Get the currency value
     *
     * @return string The current currency value.
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
