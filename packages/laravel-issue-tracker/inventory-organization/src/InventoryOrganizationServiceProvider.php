<?php

namespace LaravelIssueTracker\InventoryOrganization;

use Illuminate\Support\ServiceProvider;

class InventoryOrganizationServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        if ( ! $this->app->routesAreCached())
        {
            require __DIR__ . '/routes.php';
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}