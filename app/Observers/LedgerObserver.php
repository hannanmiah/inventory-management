<?php

namespace App\Observers;

use App\Models\Ledger;

class LedgerObserver
{
    /**
     * Handle the Ledger "created" event.
     */
    public function created(Ledger $ledger): void
    {
        // updated balance based on
    }

    /**
     * Handle the Ledger "updated" event.
     */
    public function updated(Ledger $ledger): void
    {
        //
    }

    /**
     * Handle the Ledger "deleted" event.
     */
    public function deleted(Ledger $ledger): void
    {
        //
    }

    /**
     * Handle the Ledger "restored" event.
     */
    public function restored(Ledger $ledger): void
    {
        //
    }

    /**
     * Handle the Ledger "force deleted" event.
     */
    public function forceDeleted(Ledger $ledger): void
    {
        //
    }
}
