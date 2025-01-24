<?php

namespace App\Queries;

use App\Contracts\QueryInerface;
use App\Models\Purchase;
use Spatie\QueryBuilder\QueryBuilder;

class PurchaseQuery implements QueryInerface
{

    public function query(): QueryBuilder
    {
        return QueryBuilder::for(Purchase::class)
            ->allowedFilters(['supplier_id', 'total_amount'])
            ->allowedFields(['id', 'supplier_id', 'total_amount'])
            ->allowedIncludes(['supplier', 'purchaseItems'])
            ->allowedSorts(['total_amount', 'created_at'])
            ->defaultSort('-created_at');
    }
}