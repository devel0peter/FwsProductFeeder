<?php

use App\Http\Controllers\ProductsController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUploadController;

Route::get('/{vue_capture?}', function () {
    return view('home');
})->where('vue_capture', '[\/\w\.-]*');

Route::get('/', function () {
    return view('home');
});

Route::get('/import-products', function () {
    $totalProducts = Product::count();
    // get all categories with count
    $categories = Category::withCount('products')
        ->orderByDesc('products_count')->get();


    return view('index', compact('totalProducts', 'categories'));
});

Route::post('/upload-file', [FileUploadController::class, 'upload'])->name('file.upload');
Route::get('/products/feed', [ProductsController::class, 'generateFeed'])->name('products.feed');
