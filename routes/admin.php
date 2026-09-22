<?php

use App\Http\Controllers\Admin\InvoicePdfController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    Route::get('/invoices/{invoice}/pdf', [InvoicePdfController::class, 'download'])->name('admin.invoice.pdf');
});
