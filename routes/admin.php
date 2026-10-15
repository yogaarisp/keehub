<?php

use App\Http\Controllers\Admin\InvoicePdfController;
use App\Http\Controllers\Admin\ServicePdfController;
use App\Http\Controllers\Admin\ThermalReceiptController;
use App\Http\Middleware\EnsureAdminAccess;
use Illuminate\Support\Facades\Route;

// Redirect /admin/login ke halaman login utama (satu pintu login)
Route::redirect('/admin/login', '/login');

Route::middleware(['web', 'auth', EnsureAdminAccess::class])->prefix('admin')->group(function () {
    Route::redirect('/service', '/admin/services');
    Route::get('/invoices/{invoice}/pdf', [InvoicePdfController::class, 'download'])->name('admin.invoice.pdf');
    Route::get('/services/{service}/work-order-pdf', [ServicePdfController::class, 'workOrder'])->name('admin.service.work-order.pdf');
    Route::get('/services/{service}/invoice-pdf', [ServicePdfController::class, 'invoice'])->name('admin.service.invoice.pdf');
    Route::get('/orders/{order}/receipt', [ThermalReceiptController::class, 'order'])->name('admin.order.receipt');
    Route::get('/services/{service}/receipt', [ThermalReceiptController::class, 'service'])->name('admin.service.receipt');
});
