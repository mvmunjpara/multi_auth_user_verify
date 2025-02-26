<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

//Category
Route::get('category',[CategoryController::class,'index'])->name('category');
Route::get('fetchcategory',[CategoryController::class,'fetchcategory'])->name('fetchcategory');
Route::get('category/create',[CategoryController::class,'create'])->name('category.create');
Route::post('category/store',[CategoryController::class,'store'])->name('category.store');
Route::get('category/edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
Route::post('category/update/{id}',[CategoryController::class,'update'])->name('category.update');
Route::post('category/destroy/{id}',[CategoryController::class,'destroy'])->name('category.destroy');

//Product
Route::get("product",[ProductController::class,'index'])->name('product');
Route::get('fetchproduct',[ProductController::class,'fetchproduct'])->name('fetchproduct');
Route::get("product/create",[ProductController::class,'create'])->name('product.create');
Route::post("product/store",[ProductController::class,'store'])->name('product.store');
Route::get("product/edit/{id}",[ProductController::class,'edit'])->name('product.edit');
Route::post('product/update/{id}',[ProductController::class,'update'])->name('product.update');
Route::post("product/destroy/{id}",[ProductController::class,'destroy'])->name('product.destroy');