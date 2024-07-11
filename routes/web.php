<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheapestProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreJsonController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::redirect('/', 'login');

Route::resource('category', CategoryController::class)->except(['destroy']);

Route::resource('product', ProductController::class)->only([
    'index', 'show'
]);

Route::get('show-products/{category?}',[CheapestProductController::class,'show']);

Route::post('cheapest-product/{product}',[CheapestProductController::class,'redirect'])->name('cheapest-product');
Route::post('sync-product/{category}',[CategoryController::class,'syncProduct'])->name('sync-product');


Route::get('/upload', [StoreJsonController::class, 'showUploadForm'])->name('upload.form');
Route::post('/upload-json', [StoreJsonController::class, 'uploadJson'])->name('upload.json');

Route::get('test',[\App\Http\Controllers\Backend\ProductController::class,'compare']);
Route::get('test1',[\App\Http\Controllers\Backend\ProductController::class,'compare1']);
