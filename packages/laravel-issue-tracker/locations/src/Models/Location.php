<?php

namespace LaravelIssueTracker\Locations\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

    protected $table = "locations";

    public function scopeSearchInDefaultColumns($query, $search = null)
    {
        return $query;

        if ( ! $search )
            return $query;

        /*return $query->where('type', 'like', '%' . $search . '%')
            ->orWhere('key', 'like', '%' . $search . '%')
            ->orWhere('value', 'like', '%' . $search . '%');*/
    }

}