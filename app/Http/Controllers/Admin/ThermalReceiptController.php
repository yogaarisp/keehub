<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Contracts\View\View;

class ThermalReceiptController extends Controller
{
    public function order(Order $order): View
    {
        $order->load(['customer', 'items']);

        return view('receipts.thermal-order', [
            'order' => $order,
            'paperSize' => Setting::get('printer_paper_size', '58mm'),
            'printLogo' => (bool) Setting::get('printer_print_logo', '1'),
            'autoCut' => (bool) Setting::get('printer_auto_cut', '1'),
            'cashDrawer' => (bool) Setting::get('printer_open_cash_drawer', '0'),
            'headerText' => Setting::get('printer_header_text', ''),
            'footerText' => Setting::get('printer_footer_text', 'Terima kasih telah berbelanja di KeeHub!'),
        ]);
    }

    public function service(Service $service): View
    {
        $service->load(['customer', 'items', 'technician']);

        return view('receipts.thermal-service', [
            'service' => $service,
            'paperSize' => Setting::get('printer_paper_size', '58mm'),
            'printLogo' => (bool) Setting::get('printer_print_logo', '1'),
            'autoCut' => (bool) Setting::get('printer_auto_cut', '1'),
            'cashDrawer' => (bool) Setting::get('printer_open_cash_drawer', '0'),
            'headerText' => Setting::get('printer_header_text', ''),
            'footerText' => Setting::get('printer_footer_text', 'Terima kasih telah mempercayakan servis di KeeHub!'),
        ]);
    }
}
