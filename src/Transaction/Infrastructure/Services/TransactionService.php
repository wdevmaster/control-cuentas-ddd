<?php

namespace Bank\Transaction\Infrastructure\Services;

use Bank\Transaction\Domain\Exceptions\InsufficientBalanceException;

use Bank\Transaction\Application\Actions\RegisterTransaction;
use Bank\Transaction\Application\DTOs\CreateTransactionDTO;

use Bank\Account\Application\Actions\UpdateAccountBalance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    public function __construct(
        private RegisterTransaction $registerTransaction,
        private UpdateAccountBalance $updateAccountBalance
    ) {}

    public function register(Request $request): void
    {
        try {
            $data = new CreateTransactionDTO(
                $request->input('accountId'),
                $request->input('type'),
                $request->input('amount'),
                $request->input('description'),
            );

            $transaction = $this->registerTransaction->execute($data);

            $this->updateAccountBalance->execute($transaction);

        } catch (InsufficientBalanceException $e) {
            throw $e;
        } catch (\InvalidArgumentException $e) {
            Log::error('Invalid argument exception: ' . $e->getMessage(), ['exception' => $e]);

            throw $e;
        }
    }
}
