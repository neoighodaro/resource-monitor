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

// -------------------------------------------------------------------------
// Auth routes
// -------------------------------------------------------------------------

Auth::routes();


// -------------------------------------------------------------------------
// Resources
// -------------------------------------------------------------------------

Route::post('resources/records/generate', 'ResourceController@generate')->middleware('token.verify');
Route::post('resources/status', 'ResourceController@updateStatus')->middleware('token.verify');
Route::resource('resources', 'ResourceController');


// -------------------------------------------------------------------------
// Users
// -------------------------------------------------------------------------

Route::resource('users', 'UsersController');


// -------------------------------------------------------------------------
// Miscellaneous
// -------------------------------------------------------------------------

Route::get('/', function () {
    return redirect(route('resources.index'));
});
