<?php

namespace LaravelIssueTracker\Locations\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

    protected $table = "locations";

    public function scopeSearchInDefaultColumns($query, $search = null)
    {
        if ( ! $search )
            return $query;

        return $query->where('location_code', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('address_line_1', 'like', '%' . $search . '%')
                    ->orWhere('town_or_city', 'like', '%' . $search . '%')
                    ->orWhere('country', 'like', '%' . $search . '%');
    }

}