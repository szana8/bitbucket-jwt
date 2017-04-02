<?php

namespace LaravelIssueTracker\Authorization\Models;


use Illuminate\Database\Eloquent\Model;
use Klaravel\Ntrust\Traits\NtrustPermissionTrait;

class Permission extends Model
{

    use NtrustPermissionTrait;

    /*
     * Role profile to get value from ntrust config file.
     */
    protected $roleProfile = 'user';

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