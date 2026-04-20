<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LspFormController;
use App\Http\Controllers\AdminLspController;
use Illuminate\Support\Facades\Route;


// Public Form
Route::get('/', [LspFormController::class, 'index'])->name('lsp-form.index');
Route::post('/lsp-form', [LspFormController::class, 'store'])->name('lsp-form.store');

// Admin Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/admin/lsp', [AdminLspController::class, 'index'])->name('admin.lsp.index');
    Route::get('/admin/lsp/export-all', [AdminLspController::class, 'exportAllDocx'])->name('admin.lsp.export-all');
    Route::get('/admin/lsp/export/{id}', [AdminLspController::class, 'exportDocx'])->name('admin.lsp.export');
    Route::delete('/admin/lsp/{id}', [AdminLspController::class, 'destroy'])->name('admin.lsp.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
