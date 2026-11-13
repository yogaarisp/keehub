<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class QuotationPdfController extends Controller
{
    public function download(Quotation $quotation): Response
    {
        $quotation->load(['items', 'customer', 'order']);

        $pdf = Pdf::loadView('pdf.quotation', ['quotation' => $quotation])
            ->setPaper('a4');

        return $pdf->download($quotation->code.'.pdf');
    }

    public function stream(Quotation $quotation): Response
    {
        $quotation->load(['items', 'customer', 'order']);

        return Pdf::loadView('pdf.quotation', ['quotation' => $quotation])
            ->setPaper('a4')
            ->stream($quotation->code.'.pdf');
    }
}
