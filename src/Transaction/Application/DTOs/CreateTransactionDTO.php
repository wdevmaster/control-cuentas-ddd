<?php

namespace Bank\Transaction\Application\DTOs;

class CreateTransactionDTO
{
    public function __construct(
        private int $accountId,
        private string $type,
        private float $amount,
        private string $description,
    ) {}

    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
