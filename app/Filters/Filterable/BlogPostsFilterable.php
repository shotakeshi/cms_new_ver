<?php

namespace App\Filters\Filterable;

use TheJano\LaravelFilterable\Abstracts\FilterableAbstract;
use TheJano\LaravelFilterable\Interfaces\FilterableInterface;
use TheJano\LaravelFilterable\Traits\QueryFiltersTrait;

class BlogPostsFilterable extends FilterableAbstract implements FilterableInterface
{
    /**
     * It contains list of Query Filters
     *
     * @var Array
     */
    protected array $filters = [
        'status' => 'App\Filters\QueryFilter\BlogPostFilter',
        'name' => 'App\Filters\QueryFilter\BlogPostSearchQueryFilter',
    ];
}

