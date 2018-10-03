<?php

use Illuminate\Support\Facades\Route;

Route::post('/response', 'ResponseController@store')->name('response.store');
Route::put('/response/{response}', 'ResponseController@update')->name('response.update');
