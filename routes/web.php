<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\KostController as AdminKostController;
use App\Http\Controllers\Admin\OwnerController as AdminOwnerController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\TenantController as AdminTenantController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\AdminVerificationOwnerController;
use App\Http\Controllers\Admin\AdminVerificationKostController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\Owner\KostController as OwnerKostController;
use App\Http\Controllers\Owner\KostVerificationController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Owner\OwnerVerificationController;
use App\Http\Controllers\Owner\PaymentController as OwnerPaymentController;
use App\Http\Controllers\Owner\ProfileController as OwnerProfileController;
use App\Http\Controllers\Owner\ReportController as OwnerReportController;
use App\Http\Controllers\Owner\TenantController as OwnerTenantController;
use App\Http\Controllers\Tenant\TenantController;
use App\Http\Controllers\Tenant\FavoriteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route untuk guest (belum login)
Route::get('/', [GuestController::class, 'home'])->name('guest.home');
Route::get('/cari-kost', [GuestController::class, 'search'])->name('guest.search');
Route::get('/kost/{slug}', [GuestController::class, 'show'])->name('guest.detail');

// Route yang membutuhkan auth dan role spesifik
Route::middleware('auth')->group(function () {

    // Route Admin - hanya untuk role admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::prefix('verification')->name('verification.')->group(function () {

        Route::prefix('owner')->name('owner.')->group(function () {
            Route::get('/', [AdminVerificationOwnerController::class, 'index'])->name('index');
            Route::get('/search', [AdminVerificationOwnerController::class, 'search'])->name('search');
            Route::get('/documents/{id}', [AdminVerificationOwnerController::class, 'show'])->name('show');
            Route::post('/documents/{id}/verify', [AdminVerificationOwnerController::class, 'verify'])->name('verify');
        });

        // Verifikasi Data Kost
        Route::prefix('kost')->name('kost.')->group(function () {
            Route::get('/', [AdminVerificationKostController::class, 'index'])->name('index');
            Route::get('/search', [AdminVerificationKostController::class, 'search'])->name('search');
            Route::get('/documents/{id}', [AdminVerificationKostController::class, 'show'])->name('show');
            Route::post('/documents/{id}/verify', [AdminVerificationKostController::class, 'verify'])->name('verify');
        });
    });

        // === Halaman Manajemen Pemilik ===
        Route::get('/owners', [AdminOwnerController::class, 'index'])->name('owners.index');
    Route::get('/owners/{id}', [AdminOwnerController::class, 'show'])->name('owners.show');
    Route::delete('/owners/{id}', [AdminOwnerController::class, 'destroy'])->name('owners.destroy');
        
        // Kost routes
        Route::get('/kost', [AdminKostController::class, 'index'])->name('kost.index');
    Route::get('/kost/{id}', [AdminKostController::class, 'show'])->name('kost.show');
    Route::delete('/kost/{id}', [AdminKostController::class, 'destroy'])->name('kost.destroy');

        // Tenant routes
         Route::get('/penyewa', [AdminTenantController::class, 'index'])->name('penyewa.index');
    Route::get('/penyewa/{id}', [AdminTenantController::class, 'show'])->name('penyewa.show');

        // Transaction routes
        Route::get('/transaksi', [AdminTransactionController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [AdminTransactionController::class, 'show'])->name('transaksi.show');

        // Report routes
        Route::get('/laporan', [AdminReportController::class, 'index'])->name('laporan.index');

        // Profile routes
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [AdminProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');
    Route::delete('/profile/photo', [AdminProfileController::class, 'removePhoto'])->name('profile.removePhoto');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.updatePassword');

        // Setting routes
        Route::get('/pengaturan', [AdminSettingController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan', [AdminSettingController::class, 'update'])->name('pengaturan.update');
    Route::post('/pengaturan/logo', [AdminSettingController::class, 'uploadLogo'])->name('pengaturan.uploadLogo');
    Route::delete('/pengaturan/logo', [AdminSettingController::class, 'removeLogo'])->name('pengaturan.removeLogo');
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

        // ============================================
        // VERIFICATION ROUTES
        // ============================================
        Route::prefix('verification')->name('verification.')->group(function () {

            // Verifikasi Data Diri (KTP)
            Route::prefix('identity')->name('identity.')->group(function () {
                Route::get('/', [OwnerVerificationController::class, 'index'])->name('index');
                Route::post('/', [OwnerVerificationController::class, 'store'])->name('store');
                Route::get('/{id}', [OwnerVerificationController::class, 'show'])->name('show');
                Route::delete('/{id}', [OwnerVerificationController::class, 'destroy'])->name('destroy');
            });

            // Verifikasi Data Kost
            Route::prefix('kost')->name('kost.')->group(function () {
                Route::get('/', [KostVerificationController::class, 'index'])->name('index');
                Route::post('/', [KostVerificationController::class, 'store'])->name('store');
                Route::get('/{id}', [KostVerificationController::class, 'show'])->name('show');
                Route::delete('/{id}', [KostVerificationController::class, 'destroy'])->name('destroy');
            });
        });

        // Profile
        Route::get('/profile', [OwnerProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile', [OwnerProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/photo', [OwnerProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');
        Route::delete('/profile/photo', [OwnerProfileController::class, 'removePhoto'])->name('profile.removePhoto');
        Route::put('/profile/bank', [OwnerProfileController::class, 'updateBank'])->name('profile.updateBank');
        Route::put('/profile/password', [OwnerProfileController::class, 'updatePassword'])->name('profile.updatePassword');
        Route::delete('/profile', [OwnerProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Route Tenant - hanya untuk role tenant
    // Route Tenant - hanya untuk role tenant

Route::middleware(['role:tenant'])
    ->prefix('tenant')
    ->name('tenant.')
    ->group(function () {

        Route::get('/dashboard', [TenantController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/kost', [TenantController::class, 'kost'])
            ->name('kost.index');

        Route::get('/kost/{slug}', [TenantController::class, 'detailKost'])
            ->name('kost.show');

        Route::get('/favorit', [FavoriteController::class, 'index'])
            ->name('favorit.index');

        Route::get('/riwayat', [TenantController::class, 'riwayat'])
            ->name('riwayat.index');

        Route::get('/profile', [TenantController::class, 'profile'])
            ->name('profile.index');

        Route::put('/profile', [TenantController::class, 'updateProfile'])
            ->name('profile.update');

        Route::post('/favorite/{boardingHouse}', [FavoriteController::class, 'toggle'])
            ->name('favorite.toggle');

        Route::get('/booking/{slug}', [TenantController::class, 'booking'])
            ->name('booking.index');

        Route::post('/booking', [TenantController::class, 'storeBooking'])
            ->name('booking.store');

        Route::get('/payment/{rental}', [TenantController::class, 'payment'])
            ->name('payment.index');

        Route::post('/payment/{rental}', [TenantController::class, 'storePayment'])
            ->name('payment.store');

        Route::get('/invoice/{rental}', [TenantController::class, 'invoice'])
            ->name('invoice.index');

        Route::get('/tagihan', [TenantController::class, 'bills'])
            ->name('bills.index');

    });
    // Profile routes - semua user yang login bisa akses
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// niddtenant



require __DIR__.'/auth.php';
