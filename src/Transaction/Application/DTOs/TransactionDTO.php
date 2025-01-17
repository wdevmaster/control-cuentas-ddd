<?php

namespace Bank\Transaction\Application\DTOs;

class TransactionDTO
{
    public function __construct(
        private int $id,
        private int $accountId,
        private string $type,
        private float $amount,
        private ?string $description,
        private string $createdAt,
    ) {}

    /**
     * Crear un DTO a partir de una entidad de transacción.
     *
     * @param object $transaction La entidad de la transacción.
     * @return self Una instancia del TransactionDTO.
     */
    public static function fromEntity($transaction): self
    {
        return new self(
            $transaction->getId(),
            $transaction->getAccountId(),
            $transaction->getType()->getValue(),
            $transaction->getAmount()->getValue(),
            $transaction->getDescription(),
            $transaction->getCreatedAt()->format(\DateTime::ATOM)
        );
    }

    /**
     * Convertir el DTO a un array.
     *
     * @return array Los datos de la transacción en formato de array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'account_id' => $this->accountId,
            'type' => $this->type,
            'amount' => $this->amount,
            'description' => $this->description,
            'created_at' => $this->createdAt,
        ];
    }

    // Métodos Getters

    /**
     * Obtener el ID de la transacción.
     *
     * @return int El ID de la transacción.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Obtener el ID de la cuenta asociada.
     *
     * @return int El ID de la cuenta asociada.
     */
    public function getAccountId(): int
    {
        return $this->accountId;
    }

    /**
     * Obtener el tipo de transacción.
     *
     * @return string El tipo de transacción (por ejemplo, 'deposit' o 'withdrawal').
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Obtener el monto de la transacción.
     *
     * @return float El monto de la transacción.
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * Obtener la descripción de la transacción.
     *
     * @return string|null La descripción de la transacción, o null si no hay descripción.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Obtener la fecha de creación de la transacción.
     *
     * @return string La fecha de creación en formato ISO 8601.
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}
