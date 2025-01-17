<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@email.com',
            'password' => 'notpassword'
        ]);

        $this->generateData();
    }

    public function generateData()
    {
        // Seed accounts table
        $accounts = [];
        $currencies = ['USD', 'EUR', 'GBP']; // Example currencies

        for ($i = 1; $i <= 10; $i++) {
            $accounts[] = [
                'account_name' => 'Account ' . $i,
                'account_number' => str_pad((string)rand(0, 9999999999), 10, '0', STR_PAD_LEFT),
                'currency' => $currencies[array_rand($currencies)],
                'balance' => rand(1000, 100000) / 100, // Random balance between 10.00 and 1000.00
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('accounts')->insert($accounts);

        // Seed transactions table
        $transactions = [];
        $types = ['deposit', 'withdrawal']; // Example transaction types

        foreach ($accounts as $index => $account) {
            for ($j = 1; $j <= rand(5, 15); $j++) {
                $transactions[] = [
                    'account_id' => $index + 1,
                    'type' => $types[array_rand($types)],
                    'amount' => rand(100, 10000) / 100, // Random amount between 1.00 and 100.00
                    'description' => 'Transaction ' . $j . ' for Account ' . ($index + 1),
                    'created_at' => now(),
                ];
            }
        }

        DB::table('transactions')->insert($transactions);
    }
}
