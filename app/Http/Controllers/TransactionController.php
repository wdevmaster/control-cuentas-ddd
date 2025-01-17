<?php

namespace App\Http\Controllers;

use Bank\Transaction\Infrastructure\Services\TransactionService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $transactionService
    ) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'accountId' => 'required|numeric|min:1',
            'type' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'description' => 'string',
        ]);

        try {
            $this->transactionService->register($request);

            return response()->json(['message' => 'Transaction processed successfully']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
