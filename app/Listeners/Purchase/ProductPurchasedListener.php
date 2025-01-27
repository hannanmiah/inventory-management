<?php

namespace App\Listeners\Purchase;

use App\Events\Purchase\ProductPurchased;

class ProductPurchasedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductPurchased $event): void
    {
        $purchase = $event->purchase;
        // decrease product stock
        $purchase->loadMissing(['purchaseItems.product', 'supplier.ledger']);
        foreach ($purchase->purchaseItems as $item) {
            $item->product->decrement('current_stock_quantity', $item->quantity);
            $item->product->save();
        }
        // update supplier credit
        if (filled($purchase->supplier->ledger)) {
            $purchase->supplier->ledger->increment('credit', $purchase->total_amount);
            $purchase->supplier->ledger->save();
        }

    }
}
