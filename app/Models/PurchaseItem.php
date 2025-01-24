<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseItem extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseItemFactory> */
    use HasFactory;

    protected $fillable = ['purchase_id', 'product_id', 'quantity', 'unit_price', 'total_price'];

    protected $casts = [
        'unit_price' => 'integer',
        'total_price' => 'integer',
        'quantity' => 'integer',
    ];
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
