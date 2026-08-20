<?php
namespace App\Filters\Traits;

use Illuminate\Http\Request;

trait HasFilter
{
    public function scopeFilter($query, $filterClass)
    {
        $filter = app($filterClass);
        return $filter->apply($query);
    }
}