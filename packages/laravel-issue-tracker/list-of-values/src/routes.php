<?php

Route::group(['prefix' => 'api/v1', 'middleware' => 'jwt.auth'], function() {
    Route::resource('ListOfValues', '\LaravelIssueTracker\ListOfValues\Controllers\ListOfValuesController');
});