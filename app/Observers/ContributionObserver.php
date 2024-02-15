<?php

namespace App\Observers;

use App\Models\Contribution;
use App\Models\Transaction;
use App\Models\TransactionType;

class ContributionObserver
{
    /**
     * Handle the Contribution "created" event.
     */
    public function created(Contribution $contribution): void
    {
        // Create a new transaction record and assign the contribution type
        Transaction::create([
            'member_id' => $contribution->member_id,
            'chama_account_id' => $contribution->chama_account_id,
            'transaction_type_id' => TransactionType::where('name', 'Contribution')->first()->id,
            'amount' => $contribution->contribution_amount,
            'transaction_date' => $contribution->contribution_date,
        ]);
    }

    /**
     * Handle the Contribution "updated" event.
     */
    public function updated(Contribution $contribution): void
    {
        //
    }

    /**
     * Handle the Contribution "deleted" event.
     */
    public function deleted(Contribution $contribution): void
    {
        //
    }

    /**
     * Handle the Contribution "restored" event.
     */
    public function restored(Contribution $contribution): void
    {
        //
    }

    /**
     * Handle the Contribution "force deleted" event.
     */
    public function forceDeleted(Contribution $contribution): void
    {
        //
    }
}
