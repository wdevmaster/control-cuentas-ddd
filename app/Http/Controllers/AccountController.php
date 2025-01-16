<?php

namespace App\Http\Controllers;

use Bank\Account\Domain\Exceptions\AccountNotFoundException;
use Bank\Account\Infrastructure\Services\AccountService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function __construct(
        private AccountService $accountService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'page' => 'numeric|min:1',
                'pageSize' => 'numeric|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation error',
                    'details' => $validator->errors(),
                ], 400);
            }

            $page = $request->get('page', 1);
            $pageSize = $request->get('pageSize', 10);

            $response = $this->accountService->listAccounts($page, $pageSize);

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'accountNumber' => 'required|string',
            'accountName' => 'required|string',
            'currency' => 'required|string',
            'balance' => 'required|numeric|min:0',
        ]);

        try {
            $response = $this->accountService->createAccount($request);

            return response()->json($response, 201);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $response = $this->accountService->getAccount($id);

            return response()->json($response, 200);
        } catch (AccountNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, Request $request)
    {
        $request->validate([
            'accountName' => 'required|string',
        ]);

        try {
            $accountName = $request->get('accountName');

            $response = $this->accountService->updateAccount($id, $accountName);

            return response()->json($response, 200);
        } catch (AccountNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $this->accountService->deleteAccount($id);

            return response()->json(['message' => 'Account deleted successfully'], 200);
        } catch (AccountNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
