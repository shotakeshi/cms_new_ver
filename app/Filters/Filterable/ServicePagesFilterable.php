<?php

namespace App\Filters\Filterable;

use TheJano\LaravelFilterable\Abstracts\FilterableAbstract;
use TheJano\LaravelFilterable\Interfaces\FilterableInterface;

class ServicePagesFilterable extends FilterableAbstract implements FilterableInterface
{
    /**
     * It contains list of Query Filters
     */
    protected array $filters = [
        'status' => 'App\Filters\QueryFilter\ServicePageFilter',
        'name' => 'App\Filters\QueryFilter\ServicePageSearchQueryFilter',
    ];
}
