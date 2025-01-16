<?php

namespace Bank\Account\Infrastructure\Services;

use Bank\Account\Domain\Exceptions\AccountNotFoundException;

use Bank\Account\Application\Actions\CreateAccount;
use Bank\Account\Application\Actions\GetAccount;
use Bank\Account\Application\Actions\UpdateAccountName;
use Bank\Account\Application\Actions\DeleteAccount;
use Bank\Account\Application\Actions\ListPaginatedAccounts;

use Bank\Account\Application\DTOs\CreateAccountDTO;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountService
{

    public function __construct(
        private CreateAccount $createAccount,
        private GetAccount $getAccount,
        private UpdateAccountName $updateAccountName,
        private DeleteAccount $deleteAccount,
        private ListPaginatedAccounts $listPaginatedAccounts
    ) {}

    /**
     * Lists accounts with pagination.
     *
     * @param int $page The page number for pagination.
     * @param int $pageSize The number of accounts per page.
     * @return array An array of paginated accounts.
     * @throws \Exception If an error occurs during account listing.
     */
    public function listAccounts(int $page, int $pageSize): array
    {
        try {
            $listPaginatedAccounts = $this->listPaginatedAccounts->execute($page, $pageSize);

            return $listPaginatedAccounts->toArray();
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage(), ['exception' => $e]);

            throw $e;
        }
    }

    /**
     * Creates a new account.
     *
     * @param Request $request The incoming request containing account details.
     * @return array The created account data.
     * @throws \InvalidArgumentException If the request data is invalid.
     * @throws \Exception If an error occurs during account creation.
     */
    public function createAccount(Request $request): array
    {
        try {
            $data = new CreateAccountDTO(
                $request->input('accountName'),
                $request->input('accountNumber'),
                $request->input('currency'),
                $request->input('balance')
            );

            $account = $this->createAccount->execute($data);

            return $account->toArray();
        } catch (\InvalidArgumentException $e) {
            Log::error('Invalid argument exception: ' . $e->getMessage(), ['exception' => $e]);

            throw $e;
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage(), ['exception' => $e]);

            throw $e;
        }
    }

    /**
     * Retrieves an account by its ID.
     *
     * @param string $id The account ID.
     * @return array The account and associated transactions.
     * @throws AccountNotFoundException If the account is not found.
     * @throws \Exception If an error occurs during account retrieval.
     */
    public function getAccount(string $id): array
    {
        try {
            $account = $this->getAccount->execute($id);

            return [
                'account' => $account->toArray(),
                'transactions' => []
            ];
        } catch (AccountNotFoundException $e) {
            Log::error('Account not found: ' . $e->getMessage(), ['exception' => $e]);

            throw $e;
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage(), ['exception' => $e]);

            throw $e;
        }
    }

    /**
     * Updates the name of an account.
     *
     * @param int $id The account ID.
     * @param string $accountName The new account name.
     * @return array The updated account data.
     * @throws AccountNotFoundException If the account is not found.
     * @throws \Exception If an error occurs during account update.
     */
    public function updateAccount(int $id, string $accountName): array
    {
        try {
            $account = $this->updateAccountName->execute($id, $accountName);

            return $account->toArray();
        } catch (AccountNotFoundException $e) {
            Log::error('Account not found: ' . $e->getMessage(), ['exception' => $e]);

            throw $e;
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage(), ['exception' => $e]);

            throw $e;
        }
    }

    /**
     * Deletes an account by its ID.
     *
     * @param int $id The account ID.
     * @return void
     * @throws AccountNotFoundException If the account is not found.
     * @throws \Exception If an error occurs during account deletion.
     */
    public function deleteAccount(int $id): void
    {
        try {
            $result = $this->deleteAccount->execute($id);

            if (!$result) {
                throw new \Exception('Account could not be deleted');
            }

            return;
        } catch (AccountNotFoundException $e) {
            Log::error('Account not found: ' . $e->getMessage(), ['exception' => $e]);

            throw $e;
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage(), ['exception' => $e]);

            throw $e;
        }
    }
}
