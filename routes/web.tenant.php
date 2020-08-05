<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'namespace' => \App\Models\Company::getNamespace(),
], function(){
    Route::get('/', 'SiteController@home')->name('home');
});

Route::get('/migrate', 'Main\SiteController@migrate')->name('migrate');
