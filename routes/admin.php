<?php

use App\Http\Controllers\Admin\InvoicePdfController;
use App\Http\Middleware\EnsureAdminAccess;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', EnsureAdminAccess::class])->prefix('admin')->group(function () {
    Route::get('/invoices/{invoice}/pdf', [InvoicePdfController::class, 'download'])->name('admin.invoice.pdf');
});
