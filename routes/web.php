<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUploadController;

Route::get('/', function () {
    $totalProducts = \App\Models\Product::count();
    // get all categories with count
    $categories = \App\Models\Category::withCount('products')->get();


    return view('index', compact('totalProducts', 'categories'));
});

Route::post('/upload-file', [FileUploadController::class, 'upload'])->name('file.upload');
