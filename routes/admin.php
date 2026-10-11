<?php

use App\Http\Controllers\Admin\InvoicePdfController;
use App\Http\Controllers\Admin\ServicePdfController;
use App\Http\Middleware\EnsureAdminAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->prefix('admin')->group(function () {
    Route::post('/login', function (Request $request) {
        $email = $request->input('email', $request->input('data.email'));
        $password = $request->input('password', $request->input('data.password'));

        if ($email && $password) {
            if (Auth::attempt(['email' => $email, 'password' => $password], $request->boolean('remember'))) {
                $request->session()->regenerate();

                return redirect()->intended('/admin');
            }

            return redirect('/admin/login')->withErrors(['email' => 'Email atau password salah.']);
        }

        return redirect('/admin/login');
    });
});

Route::middleware(['web', 'auth', EnsureAdminAccess::class])->prefix('admin')->group(function () {
    Route::redirect('/service', '/admin/services');
    Route::get('/invoices/{invoice}/pdf', [InvoicePdfController::class, 'download'])->name('admin.invoice.pdf');
    Route::get('/services/{service}/work-order-pdf', [ServicePdfController::class, 'workOrder'])->name('admin.service.work-order.pdf');
    Route::get('/services/{service}/invoice-pdf', [ServicePdfController::class, 'invoice'])->name('admin.service.invoice.pdf');
});
