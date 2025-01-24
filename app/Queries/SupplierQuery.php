<?php

namespace App\Queries;

use App\Contracts\QueryInerface;
use App\Models\Supplier;
use Spatie\QueryBuilder\QueryBuilder;

class SupplierQuery implements QueryInerface
{

    public function query(): QueryBuilder
    {
        return QueryBuilder::for(Supplier::class)
            ->allowedFilters(['name', 'contact_info', 'address'])
            ->allowedFields(['id', 'name', 'contact_info', 'address', 'created_at'])
            ->allowedIncludes(['ledger', 'purchases'])
            ->allowedSorts(['created_at'])
            ->defaultSort('-created_at');
    }
}