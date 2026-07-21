<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/', function () {
            return view('admin.index');
        })->name('admin.dashboard');
    });
    
    Route::middleware(['role:owner'])->prefix('owner')->group(function () {
        Route::get('/', function () {
            return view('owner.index');
        })->name('owner.dashboard');
    });
    
    Route::middleware(['role:tenant'])->prefix('tenant')->group(function () {
        Route::get('/', function () {
            return view('tenant.index');
        })->name('tenant.dashboard');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
