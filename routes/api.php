<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:user_model')->group(function(){

    
});
Route::controller( AuthController::class)->group(function(){
    Route::post('register', 'Register');
    Route::post('login', 'Login');
    Route::post('logout', 'Logout');
});