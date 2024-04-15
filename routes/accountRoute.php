
<?php

use Illuminate\Support\Facades\Route;



Route::get('getAccount', 'accountController@show');
Route::get('getAccount/{id}', 'accountController@showById');

Route::post('openAccount', 'accountController@openAccount');
Route::delete('deleteAccount/{id}', 'accountController@destroy');
Route::put('closeAccount/{id}', 'accountController@closeAccount');
