<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Owner\ActivityLogController;
use App\Http\Controllers\Owner\BillController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\ExpenseController;
use App\Http\Controllers\Owner\FinancialReportController;
use App\Http\Controllers\Owner\OccupancyController;
use App\Http\Controllers\Owner\PaymentVerificationController;
use App\Http\Controllers\Owner\RoomController;
use App\Http\Controllers\Owner\SettingController as OwnerSettingController;
use App\Http\Controllers\Tenant\TenantBillController;
use App\Http\Controllers\Tenant\TenantDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Rute Utama
Route::get('/', function () {
    if (Auth::check()) {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return $user->isOwner()
            ? redirect()->route('owner.dashboard')
            : redirect()->route('tenant.dashboard');
    }

    return redirect()->route('login');
});

// Route Guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:3,1');
});

// Route Terproteksi Autentikasi
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Portal Owner
    Route::middleware('role:owner')->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('rooms', RoomController::class)->except(['create', 'edit']);
        Route::get('tenants', [OccupancyController::class, 'index'])->name('tenants.index');
        Route::post('occupancies', [OccupancyController::class, 'store'])->name('occupancies.store');
        Route::post('occupancies/{occupancy}/checkout', [OccupancyController::class, 'checkout'])->name('occupancies.checkout');
        Route::resource('bills', BillController::class)->only(['index', 'store']);
        Route::get('payments', [PaymentVerificationController::class, 'index'])->name('payments.index');
        Route::post('payments/{payment}/verify', [PaymentVerificationController::class, 'verify'])->name('payments.verify');
        Route::post('bills/{bill}/cash-payment', [PaymentVerificationController::class, 'storeCash'])->name('bills.cash-payment');
        Route::resource('expenses', ExpenseController::class)->only(['index', 'store', 'destroy']);
        Route::get('reports', [FinancialReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export-csv', [FinancialReportController::class, 'exportCsv'])->name('reports.export-csv');
        Route::get('logs', [ActivityLogController::class, 'index'])->name('logs.index');
        Route::get('/bookings', [App\Http\Controllers\Owner\BookingApprovalController::class, 'index'])->name('bookings.index');
        Route::post('/bookings/{occupancy}/approve', [App\Http\Controllers\Owner\BookingApprovalController::class, 'approve'])->name('bookings.approve');
        Route::post('/bookings/{occupancy}/reject', [App\Http\Controllers\Owner\BookingApprovalController::class, 'reject'])->name('bookings.reject');

        // Pengaturan Akun Owner
        Route::get('settings', [OwnerSettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [OwnerSettingController::class, 'update'])->name('settings.update');

        // Verifikasi Pembayaran
        Route::get('/payments', [App\Http\Controllers\Owner\PaymentVerificationController::class, 'index'])->name('payments.index');
        Route::post('/payments/{payment}/approve', [App\Http\Controllers\Owner\PaymentVerificationController::class, 'approve'])->name('payments.approve');
        Route::post('/payments/{payment}/reject', [App\Http\Controllers\Owner\PaymentVerificationController::class, 'reject'])->name('payments.reject');
    });

    // Portal Tenant
    Route::middleware('role:tenant')->prefix('tenant')->name('tenant.')->group(function () {
        Route::get('/dashboard', [TenantDashboardController::class, 'index'])->name('dashboard');
        Route::get('bills', [TenantBillController::class, 'index'])->name('bills.index');
        Route::get('bills/{bill}', [TenantBillController::class, 'show'])->name('bills.show');
        Route::post('bills/{bill}/confirm', [TenantBillController::class, 'confirmPayment'])->name('bills.confirm');
        Route::get('/rooms', [App\Http\Controllers\Tenant\TenantBookingController::class, 'index'])->name('rooms.index');
        Route::post('/rooms/{room}/book', [App\Http\Controllers\Tenant\TenantBookingController::class, 'store'])->name('rooms.book');
    });
});