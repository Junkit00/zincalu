<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartController;


Route::get('/', [PartController::class, 'index'])->name('dashboard');

// Part pages
Route::get('/parts', [PartController::class, 'index'])->name('parts.index');
Route::get('/parts/{id}', [PartController::class, 'show'])->name('parts.show');

// file downloads
Route::get('/pdf/{file}', function ($file) {
    $path = public_path('uploads/parts/pdfs/' . $file);
    if (!file_exists($path)) abort(404);
    return response()->download($path);
})->name('pdf.download');