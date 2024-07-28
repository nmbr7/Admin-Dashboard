<?php

use Illuminate\Support\Facades\Route;

Route::get('resources/{type}', 'App\Http\Controllers\ResourceController@index');
Route::post('resources/{type}', 'App\Http\Controllers\ResourceController@store');
Route::put('resources/{type}/{id}', 'App\Http\Controllers\ResourceController@update');

Route::post('login/', 'App\Http\Controllers\LoginController@login');
