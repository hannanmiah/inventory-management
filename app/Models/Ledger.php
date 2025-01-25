<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ledger extends Model
{
    /** @use HasFactory<\Database\Factories\LedgerFactory> */
    use HasFactory;

    protected $fillable = ['supplier_id', 'credit', 'debit', 'balance', 'transaction_date', 'remarks'];

    protected $casts = [
        'credit' => 'integer',
        'debit' => 'integer',
        'balance' => 'integer',
        'transaction_date' => 'date'
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    protected static function booted(): void
    {
        static::saving(function (Ledger $ledger) {
            // update balance by calculating credit and debit
            $credit = $ledger->credit;
            $debit = $ledger->debit;
            $balance = $ledger->balance;

            $balance += $credit - $debit;
            $ledger->balance = $balance;
        });
    }
}
