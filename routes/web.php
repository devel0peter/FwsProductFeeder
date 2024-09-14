<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUploadController;

Route::get('/', function () {
    return view('index');
});

Route::post('/upload-file', [FileUploadController::class, 'upload'])->name('file.upload');
