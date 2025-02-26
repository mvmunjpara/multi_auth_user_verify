<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/user/logout',[App\Http\Controllers\Auth\LoginController::class,'userLogout'])->name('user.logout');

//Admin
Route::group(['prefix'=>'admin'],function(){
        Route::group(['middleware'=>'admin.guest'],function(){
        Route::view('/login','admin.login')->name('admin.login');
        Route::view('/register','admin.register')->name('admin.register');
        Route::post('/login',[App\Http\Controllers\AdminController::class,'authenticate'])->name('admin.auth');
        Route::post('/register',[App\Http\Controllers\AdminController::class,'register'])->name('admin.register');
    });

    Route::group(['middleware'=>'admin.auth'],function(){
        Route::get('/dashboard',[App\Http\Controllers\DashboardController::class,'dashboard'])->name('admin.dashboard');
        Route::post('/logout',[App\Http\Controllers\AdminController::class,'logout'])->name('admin.logout');
    });
});