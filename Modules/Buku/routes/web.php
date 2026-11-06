<?php

use Illuminate\Support\Facades\Route;
use Modules\Buku\Http\Controllers\BukuController;

Route::middleware('auth')->prefix('buku')->name('buku.')->group(function () {
    // Admin & user: hanya melihat daftar
    Route::get('/', [BukuController::class, 'index'])->name('index');

    // Khusus admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/create', [BukuController::class, 'create'])->name('create');
        Route::post('/', [BukuController::class, 'store'])->name('store');
        Route::get('/{buku}/edit', [BukuController::class, 'edit'])->name('edit');
        Route::put('/{buku}', [BukuController::class, 'update'])->name('update');
        Route::delete('/{buku}', [BukuController::class, 'destroy'])->name('destroy');
    });
});
