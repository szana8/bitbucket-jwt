<?php

namespace LaravelIssueTracker\InventoryOrganization\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryOrganization extends Model
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