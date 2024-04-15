
<?php

use Illuminate\Support\Facades\Route;



Route::post('register', 'userController@register');

Route::post('login', 'userController@login');