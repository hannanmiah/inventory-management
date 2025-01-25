<?php

namespace App\Http\Resources;

use App\Models\Ledger;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Ledger
 */
class LedgerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'supplier_id' => $this->supplier_id,
            'credit' => $this->credit,
            'debit' => $this->debit,
            'balance' => $this->balance,
            'transaction_date' => $this->transaction_date,
            'remarks' => $this->remarks,
            'supplier' => SupplierResource::make($this->whenLoaded('supplier')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
