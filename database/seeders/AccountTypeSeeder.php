<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define account types
        $accountTypes = [
            ['name' => 'Contribution'],
            ['name' => 'Loan'],
            ['name' => 'Investment'],
        ];

        // Seed the account_types table
        AccountType::insert($accountTypes);
    }
}
