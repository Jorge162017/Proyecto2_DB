
<?php

use Illuminate\Support\Facades\Route;



Route::get('getAccount', 'accountController@show');

Route::post('openAccount', 'accountController@openAccount');
Route::delete('deleteAccount/{id}', 'accountController@destroy');
Route::put('closeAccount/{id}', 'accountController@closeAccount');
