<?php

namespace App\Queries;

use App\Contracts\QueryInerface;
use App\Models\Category;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryQuery implements QueryInerface
{

    public function query(): QueryBuilder
    {
        return QueryBuilder::for(Category::class)
            ->allowedFilters(['name'])
            ->allowedFields(['id', 'name'])
            ->allowedIncludes(['products'])
            ->allowedSorts('name')
            ->defaultSort('name');
    }
}