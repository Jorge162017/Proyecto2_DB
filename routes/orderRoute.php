
<?php

use Illuminate\Support\Facades\Route;



Route::get('getOrderDish/{id}', 'ordenPlatoController@show');
Route::get('getOrderDrink/{id}', 'ordenBebidaController@show');



Route::post('saveOrderPlato', 'ordenPlatoController@savePlato');
Route::post('saveOrderBebida', 'ordenBebidaController@saveBebida');


//gets

Route::get('getOrderDishPending', 'ordenPlatoController@getPending');
Route::get('getOrderDishDone', 'ordenPlatoController@getDone');



Route::get('getOrderDrinkPending', 'ordenBebidaController@getPending');
Route::get('getOrderDrinkDone', 'ordenBebidaController@getDone');


//checks

Route::post('doneOrderPlato/{id}', 'ordenPlatoController@checkDone');
Route::post('pendingOrderPlato/{id}', 'ordenPlatoController@checkPending');



Route::post('doneOrderDrink/{id}', 'ordenBebidaController@checkDone');
Route::post('pendingOrderDrink/{id}', 'ordenBebidaController@checkPending');