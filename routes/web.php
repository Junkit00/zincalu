<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;

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

// Customer Page
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/customers/{customer}', [CustomerController::class, 'parts'])->name('customers.part');
