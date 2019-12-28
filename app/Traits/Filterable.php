<?php

namespace App\Traits;

use App\Filters\Filters;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Filters the class by its filter
     *
     * @param   Builder $query
     * @param   Filters $filters
     *
     * @return  mixed
     */
    public function scopeFilter(Builder $query, Filters $filters)
    {
        return $filters->apply($query);
    }
}


