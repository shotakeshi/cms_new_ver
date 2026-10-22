<?php

namespace App\Filters\Filterable;

use TheJano\LaravelFilterable\Abstracts\FilterableAbstract;
use TheJano\LaravelFilterable\Interfaces\FilterableInterface;

class LandingPagesFilterable extends FilterableAbstract implements FilterableInterface
{
    /**
     * It contains list of Query Filters
     *
     * @var Array
     */
    protected array $filters = [
        'status' => 'App\Filters\QueryFilter\LandingPageFilter',
        'name' => 'App\Filters\QueryFilter\LandingPageSearchQueryFilter',
    ];
}

