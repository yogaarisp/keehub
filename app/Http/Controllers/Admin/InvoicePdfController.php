<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class InvoicePdfController extends Controller
{
    public function download(Invoice $invoice): Response
    {
        $invoice->load(['order.items', 'items', 'customer']);

        $pdf = Pdf::loadView('pdf.invoice', ['invoice' => $invoice])
            ->setPaper('a4');

        return $pdf->download($invoice->code.'.pdf');
    }

    public function stream(Invoice $invoice): Response
    {
        $invoice->load(['order.items', 'items', 'customer']);

        return Pdf::loadView('pdf.invoice', ['invoice' => $invoice])->setPaper('a4')->stream($invoice->code.'.pdf');
    }
}
