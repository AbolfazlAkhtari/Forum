<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $filters = [];
    protected $request;
    protected $builder;

    /**
     * ThreadFilters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;
        foreach ($this->filters as $filter) {
            if ($this->hasFilter($filter)) {
                $this->$filter($this->request->$filter);
            }
        }
        return $this->builder;
    }

    /**
     * @param $filter
     * @return bool
     */
    protected function hasFilter($filter): bool
    {
        return method_exists($this, $filter) && $this->request->has($filter);
    }
}
