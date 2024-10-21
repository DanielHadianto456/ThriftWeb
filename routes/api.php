<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\kategoriController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:user_model')->group(function(){

    Route::controller(kategoriController::class)->group(function(){

        Route::get('admin/kategori', 'getAll');
        Route::post('admin/kategori/add', 'addCategory');
        Route::patch('admin/kategori/edit/{id}', 'editCategory');
        Route::delete('admin/kategori/delete/{id}', 'deleteCategory');

    });
    
});
Route::controller( AuthController::class)->group(function(){
    Route::post('register', 'Register');
    Route::post('login', 'Login');
    Route::post('logout', 'Logout');
});