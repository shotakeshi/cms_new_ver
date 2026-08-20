<?php
namespace App\Filters;

use Illuminate\Http\Request;

abstract class BaseFilter
{
    protected Request $request;
    protected $query;

    protected array $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($query)
    {
        $this->query = $query;

        foreach ($this->filters as $filter) {
            if ($this->request->filled($filter) && method_exists($this, $filter)) {
                $this->{$filter}($this->request->get($filter));
            }
        }

        return $this->query;
    }

    /* ====== Common Filters ====== */

    protected function sort($value)
    {
        // sort=name,-created_at
        foreach (explode(',', $value) as $field) {
            $direction = str_starts_with($field, '-') ? 'desc' : 'asc';
            $this->query->orderBy(ltrim($field, '-'), $direction);
        }
    }

    protected function date_from($value)
    {
        $this->query->whereDate('created_at', '>=', $value);
    }

    protected function date_to($value)
    {
        $this->query->whereDate('created_at', '<=', $value);
    }
}
