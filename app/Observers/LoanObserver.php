<?php

namespace App\Observers;

use App\Models\Loan;
use App\Models\Transaction;
use App\Models\TransactionType;

class LoanObserver
{
    /**
     * Handle the Loan "created" event.
     */
    public function created(Loan $loan): void
    {
        Transaction::create([
            'member_id' => $loan->member_id,
            'transaction_type_id' => TransactionType::where('name', 'Loan')->first()->id,
            'amount' => $loan->investment_amount,
            'transaction_date' => $loan->investment_date,
        ]);
    }

    /**
     * Handle the Loan "updated" event.
     */
    public function updated(Loan $loan): void
    {
        //
    }

    /**
     * Handle the Loan "deleted" event.
     */
    public function deleted(Loan $loan): void
    {
        //
    }

    /**
     * Handle the Loan "restored" event.
     */
    public function restored(Loan $loan): void
    {
        //
    }

    /**
     * Handle the Loan "force deleted" event.
     */
    public function forceDeleted(Loan $loan): void
    {
        //
    }
}
