
<?php

use Illuminate\Support\Facades\Route;



Route::get('getTables', 'tableController@show');
Route::post('saveTable', 'tableController@save');
Route::delete('deleteTable/{id}', 'tableController@destroy');
Route::put('updateTable/{id}', 'tableController@update');
