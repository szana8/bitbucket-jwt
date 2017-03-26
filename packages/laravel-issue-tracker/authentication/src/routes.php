<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'api/v1/authentication', 'middleware' => ['api']], function() {

    Route::post('database/login', '\LaravelIssueTracker\Authentication\Controllers\DatabaseAuthController@login');
    Route::get('github/login', '\LaravelIssueTracker\Authentication\Controllers\GithubAuthController@login');
    Route::get('facebook/login', '\LaravelIssueTracker\Authentication\Controllers\FacebookAuthController@login');
    Route::get('bitbucket/login', '\LaravelIssueTracker\Authentication\Controllers\BitbucketAuthController@login');
    Route::get('google/login', '\LaravelIssueTracker\Authentication\Controllers\GoogleAuthController@login');


    Route::get('getUserByToken', '\LaravelIssueTracker\Authentication\Controllers\DatabaseAuthController@getUserByToken')->middleware('jwt.auth');

});
