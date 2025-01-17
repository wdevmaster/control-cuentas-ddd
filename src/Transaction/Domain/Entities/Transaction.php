<?php

namespace Bank\Transaction\Domain\Entities;

use Bank\Transaction\Domain\ValueObjects\Amount;
use Bank\Transaction\Domain\ValueObjects\Type;
use DateTimeImmutable;

class Transaction
{
    public function __construct(
        private string $accountId,
        private Type $type,
        private Amount $amount,
        private string $description,
        private DateTimeImmutable $createdAt,
        private ?string $id = null,
    ){}

    /**
     * Creates a new instance of Transaction.
     *
     * @param string $accountId The account ID.
     * @param string $type The transaction type.
     * @param float $amount The transaction amount.
     * @return self
     */
    public static function create(
        string $accountId,
        string $type,
        float $amount,
        string $description
    ) : self {

        return new self(
            $accountId,
            Type::create($type),
            Amount::create($amount),
            $description,
            new DateTimeImmutable(),
        );
    }

    /**
     * Gets the unique identifier of the transaction.
     *
     * @return ?string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set the ID of the transaction.
     *
     * @param string $id The ID to set.
     * @return void
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Get the account ID
     *
     * @return string The account ID.
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * Get the transaction type
     *
     * @return Type The transaction type.
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * Get the transaction amount
     *
     * @return Amount The transaction amount.
     */
    public function getAmount(): Amount
    {
        return $this->amount;
    }

    /**
     * Get the description
     *
     * @return string The description.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get the transaction creation date
     *
     * @return DateTimeImmutable The transaction creation date.
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
