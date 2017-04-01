<?php

namespace LaravelIssueTracker\Authorization\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
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