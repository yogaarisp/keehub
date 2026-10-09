<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ServicePdfController extends Controller
{
    public function workOrder(Service $service): Response
    {
        $service->load(['customer', 'technician', 'items', 'statusHistory']);

        $pdf = Pdf::loadView('pdf.service-work-order', ['service' => $service])
            ->setPaper('a4');

        return $pdf->stream('WO-'.$service->code.'.pdf');
    }

    public function invoice(Service $service): Response
    {
        $service->load(['customer', 'technician', 'items']);

        if (! $service->invoice_number) {
            $service->invoice_number = Service::generateInvoiceNumber();
            $service->save();
        }

        $pdf = Pdf::loadView('pdf.service-invoice', ['service' => $service])
            ->setPaper('a4');

        return $pdf->stream('INV-'.($service->invoice_number ?: $service->code).'.pdf');
    }
}
