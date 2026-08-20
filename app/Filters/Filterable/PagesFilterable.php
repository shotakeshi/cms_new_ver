<?php

namespace App\Filters\Filterable;

use TheJano\LaravelFilterable\Abstracts\FilterableAbstract;
use TheJano\LaravelFilterable\Interfaces\FilterableInterface;

class PagesFilterable extends FilterableAbstract implements FilterableInterface
{
    /**
     * It contains list of Query Filters
     *
     * @var Array
     */
    protected array $filters = [
        'status' => 'App\Filters\QueryFilter\PageFilter',
        'name' => 'App\Filters\QueryFilter\PageSearchQueryFilter',
    ];
}

