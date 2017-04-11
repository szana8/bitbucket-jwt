<?php

Route::group(['prefix' => 'api/v1', 'middleware' => 'jwt.auth'], function() {

    Route::resource('locations', '\LaravelIssueTracker\Locations\Controllers\LocationController');

});