<?php

namespace Bank\Account\Domain\Repositories;

use Bank\Account\Domain\Entities\Account;

interface AccountRepository
{
    public function findById(int $id): ?Account;

    public function findByAccountNumber(string $accountNumber): ?Account;

    public function findPaginated(int $offset, int $limit): array;

    public function countAll(): int;

    public function save(Account $account): Account;

    public function delete(int $id): bool;
}
