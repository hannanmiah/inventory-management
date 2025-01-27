<?php

namespace App\Models;

use App\Concerns\GeneratesSku;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, GeneratesSku,SoftDeletes,CascadeSoftDeletes;

    protected $fillable = ['category_id', 'name', 'sku', 'price', 'initial_stock_quantity', 'current_stock_quantity'];

    protected $casts = [
        'price' => 'integer',
        'initial_stock_quantity' => 'integer',
        'current_stock_quantity' => 'integer',
    ];

    protected $cascadeDeletes = ['purchaseItems'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function purchaseItems(): HasMany{
        return $this->hasMany(PurchaseItem::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            // update current stock quantity as initial stock quantity
            $product->current_stock_quantity = $product->initial_stock_quantity;
        });
    }
}
