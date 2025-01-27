<?php

namespace App\Queries;

use App\Contracts\QueryInerface;
use App\Models\Product;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductQuery implements QueryInerface
{

    public function query(): QueryBuilder
    {
        return QueryBuilder::for(Product::class)
            ->allowedFilters(['name', AllowedFilter::exact('category_id'), AllowedFilter::exact('sku')])
            ->allowedFields(['id', 'name', 'sku', 'price', 'initial_stock_quantity', 'current_stock_quantity', 'category_id'])
            ->allowedIncludes(['category', 'purchaseItems'])
            ->allowedSorts('name', 'price', 'created_at')
            ->defaultSort('-created_at');
    }
}