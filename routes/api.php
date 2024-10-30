<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\pakaianController;
use App\Http\Controllers\transaksiController;
use App\Http\Controllers\pembelianDetailController;
use App\Http\Controllers\userController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:user_model')->group(function(){

    Route::controller(kategoriController::class)->group(function(){
        //user
        Route::get('user/kategori', 'getAll');
        //admin
        Route::get('admin/kategori', 'getAll');
        Route::post('admin/kategori/add', 'addCategory');
        Route::patch('admin/kategori/edit/{id}', 'editCategory');
        Route::delete('admin/kategori/delete/{id}', 'deleteCategory');

    });

    Route::controller(pakaianController::class)->group(function(){
        //user
        Route::get('user/pakaian', 'getAll');
        // Route::get('user/pakaian', 'getPembelianUser');
        //admin
        Route::get('admin/pakaian', 'getAll');
        Route::post('admin/pakaian/add', 'addPakaian');
        Route::patch('admin/pakaian/edit/{id}', 'editPakaian');
        Route::delete('admin/pakaian/delete/{id}', 'deletePakaian');
        Route::post('admin/pakaian/add-stock/{id}', 'addStock'); // Add this line
    });

    Route::controller(transaksiController::class)->group(function(){
        //User
        Route::post('user/pembelian/add', 'addPembelian2');
        Route::get('user/pembelian/detail/{id}', 'getPembelianId');
        // Route::get('user/pembelian', 'getAllPembelian');
        Route::get('user/pembelian', 'getPembelianUser');
        Route::patch('user/pembelian/confirm/{id}', 'updateStatus');
        //Admin
        Route::get('admin/pembelian/detail/{id}', 'getPembelianId');
        Route::get('admin/pembelian', 'getAllPembelian');
        Route::patch('admin/pembelian/edit/{id}', 'editPakaian');
        Route::delete('admin/pembelian/delete/{id}', 'deletePakaian');
        Route::post('admin/pembelian/add-stock/{id}', 'addStock');
        Route::delete('admin/pembelian/delete/{id}', 'deleteTransaction');
    });

    Route::controller(pembelianDetailController::class)->group(function(){
        Route::post('user/pembelian/detail/{pembelian_id}',  'addPembelianDetail');
    });

    Route::controller(userController::class)->group(function(){
        Route::post('/user/update-profile',  'updateProfile');
        Route::post('/user/reset-password', 'resetPassword');
        Route::get('/user/profile',  'getProfile');
    });
    
    
});
Route::controller( AuthController::class)->group(function(){
    Route::post('register', 'Register');
    Route::post('login', 'Login');
    Route::post('logout', 'Logout');
});