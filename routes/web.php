<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheapestProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreJsonController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::redirect('/', 'login');

Route::middleware('auth')->group(function () {

    Route::resource('category', CategoryController::class)->except(['destroy']);

    Route::get('product', ProductController::class)->name('product.index');

    Route::get('show-products/{category}', [CheapestProductController::class, 'show'])->name('compare.category.products');

    Route::post('cheapest-product/{product}', [CheapestProductController::class, 'redirect'])->name('cheapest-product');
    Route::post('sync-product/{category}', [CategoryController::class, 'syncProduct'])->name('sync-product');

    Route::get('index-product/{category}', [CategoryController::class, 'showProductsOfCategory'])->name('index-product');

    Route::get('/upload', [StoreJsonController::class, 'showUploadForm'])->name('upload.form');
    Route::post('/upload-json', [StoreJsonController::class, 'uploadJson'])->name('upload.json');

});
