<?php

namespace App\Actions\Purchase;

use App\Models\Purchase;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateItems
{
    use AsAction;

    public function handle(Purchase $purchase, array $items): void
    {
        $purchase->purchaseItems()->createMany($items);
    }
}
