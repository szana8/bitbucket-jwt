<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Klaravel\Ntrust\Traits\NtrustUserTrait;
use LaravelIssueTracker\User\Models\User as LaravelIssueUser;

class User extends Authenticatable
{
    use Notifiable, LaravelIssueUser, NtrustUserTrait;

    /*
     * Role profile to get value from ntrust config file.
     */
    protected $roleProfile = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'id'
    ];
}
