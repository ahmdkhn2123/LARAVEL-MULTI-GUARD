<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;




Auth::routes();

//Auth::routes() is just a helper class that helps you generate all the routes required for user authentication.
Route::prefix('user')->name('user.')->group(function(){
    Route::middleware(['guest:web'])->group(function(){
        Route::get('/login',[UserController::class,'Lpage'])->name('login');
        Route::get('/register',[UserController::class,'Rpage'])->name('register');
        Route::post('/create',[UserController::class,'create'])->name('create');
        Route::post('/login',[UserController::class,'dologin'])->name('dologin');
    });

    Route::middleware(['auth:web'])->group(function(){
        Route::view('/home','dashboard.user.home')->name('home');
        Route::POST('/logout',[UserController::class,'logout'])->name('logout');

    });
});

//Admin->guards
Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware(['guest:admin'])->group(function(){
        Route::get('/login',[AdminController::class,'Lpage'])->name('login');;
        Route::post('/login',[AdminController::class,'dologin'])->name('dologin');
    });

    Route::middleware(['auth:admin'])->group(function(){
        Route::view('/home','dashboard.admin.home')->name('home');
        Route::POST('/logout',[AdminController::class,'logout'])->name('logout');

    });
});
