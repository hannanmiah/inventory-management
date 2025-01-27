<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ledger extends Model
{
    /** @use HasFactory<\Database\Factories\LedgerFactory> */
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

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

    /**
     * scope transactionBetween
     */
    public function scopeTransactionBetween($query, $start_date, $end_date)
    {
        if (blank($start_date) || blank($end_date)) return $query;
        return $query->whereDate('transaction_date', '>=', $start_date)->whereDate('transaction_date', '<=', $end_date);
    }
}
