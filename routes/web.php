<?php

use App\Http\Controllers\Owner\DocumentController as OwnerDocumentController;
use App\Http\Controllers\Owner\KostController as OwnerKostController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Owner\PaymentController as OwnerPaymentController;
use App\Http\Controllers\Owner\ProfileController as OwnerProfileController;
use App\Http\Controllers\Owner\ReportController as OwnerReportController;
use App\Http\Controllers\Owner\TenantController as OwnerTenantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route untuk guest (belum login)
Route::get('/', function () {
    return redirect('login');
});

// Route yang membutuhkan auth dan role spesifik
Route::middleware('auth')->group(function () {

    // Route Admin - hanya untuk role admin
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.index');
        })->name('admin.dashboard');

        // Route admin lainnya
        Route::get('/users', function () {
            return view('admin.users');
        })->name('admin.users');
    });

    // Route Owner - hanya untuk role owner
    Route::middleware(['role:owner'])->prefix('owner')->name('owner.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [OwnerController::class, 'index'])->name('dashboard');

        // Kost Management
        Route::resource('kost', OwnerKostController::class)->names([
            'index' => 'kost.index',
            'create' => 'kost.create',
            'store' => 'kost.store',
            'show' => 'kost.show',
            'edit' => 'kost.edit',
            'update' => 'kost.update',
            'destroy' => 'kost.destroy',
        ]);

        Route::delete('/kost/photo/{id}', [OwnerKostController::class, 'deletePhoto'])->name('kost.deletePhoto');

        // Tenant Management
        Route::get('/tenant', [OwnerTenantController::class, 'index'])->name('tenant.index');
        Route::get('/tenant/{id}', [OwnerTenantController::class, 'show'])->name('tenant.show');

        // Payment Management
        Route::get('/payment', [OwnerPaymentController::class, 'index'])->name('payment.index');
        Route::get('/payment/{id}', [OwnerPaymentController::class, 'show'])->name('payment.show');
        Route::post('/payment/{id}/verify', [OwnerPaymentController::class, 'verify'])->name('payment.verify');
        Route::post('/payment/{id}/reject', [OwnerPaymentController::class, 'reject'])->name('payment.reject');

        // Report Management
        Route::get('/report', [OwnerReportController::class, 'index'])->name('report.index');

        // Document Verification
        Route::resource('document', OwnerDocumentController::class)->names([
            'index' => 'document.index',
            'create' => 'document.create',
            'store' => 'document.store',
            'show' => 'document.show',
            'edit' => 'document.edit',
            'update' => 'document.update',
            'destroy' => 'document.destroy',
        ]);

        Route::get('/document', [OwnerDocumentController::class, 'index'])->name('document.index');
        Route::post('/document', [OwnerDocumentController::class, 'store'])->name('document.store');
        Route::get('/document/{id}', [OwnerDocumentController::class, 'show'])->name('document.show');
        Route::put('/document/{id}', [OwnerDocumentController::class, 'update'])->name('document.update');
        Route::delete('/document/{id}', [OwnerDocumentController::class, 'destroy'])->name('document.destroy');

        Route::get('/profile', [OwnerProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile', [OwnerProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/photo', [OwnerProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');
        Route::delete('/profile/photo', [OwnerProfileController::class, 'removePhoto'])->name('profile.removePhoto');
        Route::put('/profile/bank', [OwnerProfileController::class, 'updateBank'])->name('profile.updateBank');
        Route::put('/profile/password', [OwnerProfileController::class, 'updatePassword'])->name('profile.updatePassword');
        Route::delete('/profile', [OwnerProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Route Tenant - hanya untuk role tenant
    Route::middleware(['role:tenant'])->prefix('tenant')->group(function () {
        Route::get('/dashboard', function () {
            return view('tenant.index');
        })->name('tenant.dashboard');
    });

    // Profile routes - semua user yang login bisa akses
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
