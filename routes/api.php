<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use gsanox\Soap2Rest\Http\Controllers\SoapRestController;

Route::post('/register', [SoapRestController::class, 'register']);
Route::delete('/unregister/{serviceId}', [SoapRestController::class, 'unregister']);
Route::post('/{serviceId}/{operation}', [SoapRestController::class, 'proxy']);