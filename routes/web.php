<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartController;

Route::get('/', [PartController::class, 'index'])->name('dashboard');

// Part pages (public)
Route::get('/parts', [PartController::class, 'index'])->name('parts.index');
Route::get('/parts/{id}', [PartController::class, 'show'])->name('parts.show');

// Manage pages (CRUD)
Route::get('/manage/parts', [PartController::class, 'manage'])->name('parts.manage');
Route::get('/manage/parts/create', [PartController::class, 'create'])->name('parts.create');
Route::post('/manage/parts', [PartController::class, 'store'])->name('parts.store');
Route::get('/manage/parts/{id}/edit', [PartController::class, 'edit'])->name('parts.edit');
Route::put('/manage/parts/{id}', [PartController::class, 'update'])->name('parts.update');
Route::delete('/manage/parts/{id}', [PartController::class, 'destroy'])->name('parts.destroy');

// file downloads (keep if desired)
Route::get('/pdf/{file}', function ($file) {
    $path = public_path('uploads/parts/pdfs/' . $file);
    if (!file_exists($path)) abort(404);
    return response()->download($path);
})->name('pdf.download');
