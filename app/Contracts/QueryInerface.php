<?php

namespace App\Contracts;

use Spatie\QueryBuilder\QueryBuilder;

interface QueryInerface
{
    public function query(): QueryBuilder;
}