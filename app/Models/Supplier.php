<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;

    protected $fillable = ['name', 'contact_info', 'address'];

    protected $casts = [
        'contact_info' => SchemalessAttributes::class,
    ];

    public function ledger(): HasOne
    {
        return $this->hasOne(Ledger::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
