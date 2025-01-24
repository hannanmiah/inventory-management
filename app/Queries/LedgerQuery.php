<?php

namespace App\Queries;

use App\Contracts\QueryInerface;
use App\Models\Ledger;
use Spatie\QueryBuilder\QueryBuilder;

class LedgerQuery implements QueryInerface
{

    public function query(): QueryBuilder
    {
        return QueryBuilder::for(Ledger::class)
            ->allowedFilters(['supplier_id', 'transaction_date'])
            ->allowedFields(['id', 'supplier_id', 'credit', 'debit', 'balance', 'transaction_date', 'remarks'])
            ->allowedIncludes(['supplier'])
            ->allowedSorts(['balance', 'transaction_date'])
            ->defaultSort('-transaction_date');
    }
}