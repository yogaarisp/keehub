<?php

use App\Http\Controllers\Admin\InvoicePdfController;
use App\Http\Controllers\Admin\ServicePdfController;
use App\Http\Middleware\EnsureAdminAccess;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', EnsureAdminAccess::class])->prefix('admin')->group(function () {
    Route::redirect('/service', '/admin/services');
    Route::get('/invoices/{invoice}/pdf', [InvoicePdfController::class, 'download'])->name('admin.invoice.pdf');
    Route::get('/services/{service}/work-order-pdf', [ServicePdfController::class, 'workOrder'])->name('admin.service.work-order.pdf');
    Route::get('/services/{service}/invoice-pdf', [ServicePdfController::class, 'invoice'])->name('admin.service.invoice.pdf');
});
