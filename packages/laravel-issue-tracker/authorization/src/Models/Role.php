<?php

namespace LaravelIssueTracker\Authorization\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    /**
     * @param $query
     * @param null $search
     * @return mixed
     */
    public function scopeSearchInDefaultColumns($query, $search = null)
    {
        return $query;
    }

}