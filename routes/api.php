<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//listing resource
Route::resource('/listings', 'API\ListingController')->except('create','edit');

Route::get('/search-listing','API\ListingController@search');
//category resource
Route::resource('/categories', 'API\CategoryController')->except('create','edit');
