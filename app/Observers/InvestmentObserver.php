<?php

namespace App\Observers;

use App\Models\Investment;
use App\Models\Transaction;
use App\Models\TransactionType;

class InvestmentObserver
{
    /**
     * Handle the Investment "created" event.
     */
    public function created(Investment $investment): void
    {
        Transaction::create([
            'member_id' => $investment->member_id,
            'chama_account_id' => $investment->chama_account_id,
            'transaction_type_id' => TransactionType::where('name', 'Investment')->first()->id,
            'amount' => $investment->investment_amount,
            'transaction_date' => $investment->investment_date,
        ]);
    }

    /**
     * Handle the Investment "updated" event.
     */
    public function updated(Investment $investment): void
    {
        //
    }

    /**
     * Handle the Investment "deleted" event.
     */
    public function deleted(Investment $investment): void
    {
        //
    }

    /**
     * Handle the Investment "restored" event.
     */
    public function restored(Investment $investment): void
    {
        //
    }

    /**
     * Handle the Investment "force deleted" event.
     */
    public function forceDeleted(Investment $investment): void
    {
        //
    }
}
