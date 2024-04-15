
<?php

use Illuminate\Support\Facades\Route;



Route::get('getArea', 'areaController@show');
Route::delete('deleteArea/{id}', 'areaController@destroy');


