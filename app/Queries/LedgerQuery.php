<?php

namespace App\Queries;

use App\Contracts\QueryInerface;
use App\Models\Ledger;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class LedgerQuery implements QueryInerface
{

    public function query(): QueryBuilder
    {
        return QueryBuilder::for(Ledger::class)
            ->allowedFilters([AllowedFilter::exact('supplier_id'), 'credit', 'debit', 'balance', AllowedFilter::scope('transaction_between')])
            ->allowedFields(['id', 'supplier_id', 'credit', 'debit', 'balance', 'transaction_date', 'remarks'])
            ->allowedIncludes(['supplier'])
            ->allowedSorts(['balance', 'transaction_date','created_at'])
            ->defaultSort('-transaction_date');
    }
}