<?php

namespace App\Actions\Purchase;

use App\Models\Purchase;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateItems
{
    use AsAction;

    public function handle(Purchase $purchase,array $items)
    {
        $purchase->purchaseItems()->delete();
        $purchase->purchaseItems()->createMany($items);
    }
}
