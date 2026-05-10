<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Donatur\DashboardController as DonaturDashboard;
use App\Http\Controllers\Donatur\ItemController;
use App\Http\Controllers\Donatur\ClaimApprovalController;
use App\Http\Controllers\Penerima\CatalogController;
use App\Http\Controllers\Penerima\ClaimController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Penerima\PaymentController;
use App\Http\Controllers\Donatur\PaymentVerifyController;

// Redirect user yang sudah login dari halaman login/register
Route::middleware('auth')->group(function () {
    Route::get('/redirect', function () {
        $user = auth()->user();
        return match($user->role) {
            'donatur'  => redirect()->route('donatur.dashboard'),
            'penerima' => redirect()->route('penerima.dashboard'),
            'admin'    => redirect()->route('admin.dashboard'),
            default    => redirect('/'),
        };
    })->name('dashboard.redirect');

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    if (auth()->check()) {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
    return view('welcome');
});

// ===== DONATUR =====
Route::middleware(['auth', 'role:donatur'])
    ->prefix('donatur')
    ->name('donatur.')
    ->group(function () {
        Route::get('/dashboard', [DonaturDashboard::class, 'index'])->name('dashboard');
        Route::resource('items', ItemController::class);
        Route::get('/claims', [ClaimApprovalController::class, 'index'])->name('claims');
        Route::patch('/claims/{claim}/approve', [ClaimApprovalController::class, 'approve'])->name('claims.approve');
        Route::patch('/claims/{claim}/reject', [ClaimApprovalController::class, 'reject'])->name('claims.reject');
        // Verifikasi pembayaran
        Route::get('/payments', [PaymentVerifyController::class, 'index'])->name('payments');
        Route::patch('/payments/{payment}/verify', [PaymentVerifyController::class, 'verify'])->name('payments.verify');
        Route::patch('/payments/{payment}/reject', [PaymentVerifyController::class, 'reject'])->name('payments.reject');
    });

// ===== PENERIMA =====
Route::middleware(['auth', 'role:penerima'])
    ->prefix('penerima')
    ->name('penerima.')
    ->group(function () {
        Route::get('/dashboard', [CatalogController::class, 'index'])->name('dashboard');
        Route::get('/katalog', [CatalogController::class, 'katalog'])->name('katalog');
        Route::post('/claim/{item}', [ClaimController::class, 'store'])->name('claim.store');
        Route::get('/riwayat', [ClaimController::class, 'riwayat'])->name('riwayat');
        // Pembayaran
        Route::get('/payment/{claim}', [PaymentController::class, 'show'])->name('payment.show');
        Route::post('/payment/{claim}', [PaymentController::class, 'store'])->name('payment.store');
    });

// ===== ADMIN =====
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::patch('/users/{user}/verify', [AdminController::class, 'verify'])->name('users.verify');
        Route::get('/items', [AdminController::class, 'items'])->name('items');
        Route::delete('/items/{item}', [AdminController::class, 'deleteItem'])->name('items.delete');
    });

require __DIR__.'/auth.php';