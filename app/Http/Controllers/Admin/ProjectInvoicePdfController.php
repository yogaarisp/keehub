<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ProjectInvoicePdfController extends Controller
{
    public function download(ProjectInvoice $projectInvoice): Response
    {
        $projectInvoice->load(['items', 'customer']);

        $pdf = Pdf::loadView('pdf.keetech-project-invoice', ['invoice' => $projectInvoice])
            ->setPaper('a4');

        return $pdf->download($projectInvoice->code.'.pdf');
    }

    public function stream(ProjectInvoice $projectInvoice): Response
    {
        $projectInvoice->load(['items', 'customer']);

        return Pdf::loadView('pdf.keetech-project-invoice', ['invoice' => $projectInvoice])
            ->setPaper('a4')
            ->stream($projectInvoice->code.'.pdf');
    }
}
