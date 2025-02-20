<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\DashboardController;
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

Route::get('account/verify/{token}', [LoginController::class, 'verifyAccount'])->name('account.verify'); 
Route::get('admin/verify/{token}',[AdminLoginController::class,'verifyAccount'])->name('admin.verify');


Route::group(['prefix'=>'account'],function(){
    //Guest Middleare
    Route::group(['middleware'=>'guest'],function(){
        Route::get('login',[LoginController::class,'index'])->name('account.login');
        Route::get('register',[LoginController::class,'register'])->name('account.register');
        Route::post('authenticate',[LoginController::class,'authenticate'])->name('account.authenticate');
        Route::post('register',[LoginController::class,'processRegister'])->name('account.processRegister');

    });


    //Auth Middleware
    Route::group(['middleware'=>'auth'],function(){
        Route::get('dashboard',[DashboardController::class,'index'])->name('account.dashboard')->middleware(['is_verify_email']);
        Route::get('logout',[LoginController::class,'logout'])->name('account.logout');

    });
});

//Admin 
Route::group(['prefix'=>'admin'],function(){
    //Admin Guest Middleare
    Route::group(['middleware'=>'admin.guest'],function(){
        Route::get('login',[AdminLoginController::class,'index'])->name('admin.login');
        Route::get('register',[AdminLoginController::class,'register'])->name('admin.register');
        Route::post('authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');
        Route::post('register',[AdminLoginController::class,'processRegister'])->name('admin.processRegister');

    });


    //Admi  Auth Middleware
    Route::group(['middleware'=>'admin.auth'],function(){
        Route::get('dashboard',[AdminDashboardController::class,'index'])->name('admin.dashboard')->middleware('is_admin_verify_email');
        Route::get('logout',[AdminLoginController::class,'logout'])->name('admin.logout');

    });
});