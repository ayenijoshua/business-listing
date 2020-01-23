<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/create-category', 'CategoryController@create')->name('create-category');
//create category
Route::post('/create-category','CategoryController@store')->name('store-category');
//all categories
Route::get('/categories','CategoryController@index')->name('categories');
//edit catgory
Route::get('/edit-category/{category}','CategoryController@edit')->name('edit-category');
//update category
Route::post('/update-category/{category}','CategoryController@update')->name('update-category');
//confirm delete category
Route::get('/delete-category/{category}','CategoryController@show')->name('show-category');
//delete category
Route::post('/delete-category/{category}','CategoryController@destroy')->name('delete-category');

//-----------------------------------------------Business Listing-------------------------------

Route::get('/create-listing', 'ListingController@create')->name('create-listing');
//create category
Route::post('/create-listing','ListingController@store')->name('store-listing');
//all categories
Route::get('/listings','ListingController@index')->name('listings');
//edit listing
Route::get('/edit-listing/{listing}','ListingController@edit')->name('edit-listing');
//update listing
Route::post('/update-listing/{listing}','ListingController@update')->name('update-listing');
//confirm delete listing
Route::get('delete-listing/{listing}', 'ListingController@show')->name('show-listing');
//delete listing
Route::post('delete-listing/{listing}', 'ListingController@destroy')->name('delete-listing');
//confirm deactivate listing
Route::get('deactivate-listing/{listing}', 'ListingController@showDeactivate')->name('show-deactivate-listing');
//deactivate listing
Route::post('deactivate-listing/{listing}', 'ListingController@deactivate')->name('deactivate-listing');
//confirm deactivate listing
Route::get('activate-listing/{listing}', 'ListingController@showActivate')->name('show-activate-listing');
// activate a listing
Route::post('activate-listing/{listing}', 'ListingController@activate')->name('activate-listing');

//Route::get()


