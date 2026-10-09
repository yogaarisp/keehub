<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Services\WhatsAppService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('q', $request->input('search', '')));
        $searched = false;
        $services = collect();
        $selectedService = null;

        if ($search !== '') {
            $searched = true;
            $cleanPhone = preg_replace('/[^0-9]/', '', $search);

            $query = Service::query()->with(['customer', 'technician', 'items', 'statusHistory.user']);

            $query->where(function ($q) use ($search, $cleanPhone) {
                $q->where('code', 'LIKE', "%{$search}%")
                    ->orWhere('invoice_number', 'LIKE', "%{$search}%");

                if (strlen($cleanPhone) >= 4) {
                    $q->orWhereHas('customer', function ($cq) use ($cleanPhone) {
                        $cq->where('whatsapp', 'LIKE', "%{$cleanPhone}%");
                        if (str_starts_with($cleanPhone, '0')) {
                            $cq->orWhere('whatsapp', 'LIKE', '%'.substr($cleanPhone, 1).'%');
                        } elseif (str_starts_with($cleanPhone, '62')) {
                            $cq->orWhere('whatsapp', 'LIKE', '%'.substr($cleanPhone, 2).'%');
                        }
                    });
                }
            });

            $services = $query->latest()->get();

            if ($request->has('code')) {
                $selectedService = $services->firstWhere('code', $request->query('code'));
            }

            if (! $selectedService && $services->isNotEmpty()) {
                $selectedService = $services->first();
            }
        }

        return view('shop.service-tracker', [
            'search' => $search,
            'searched' => $searched,
            'services' => $services,
            'selectedService' => $selectedService,
            'serviceTypes' => Service::TYPES,
        ]);
    }

    public function create(Request $request): View
    {
        return $this->index($request);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['required', 'string', 'max:25'],
            'device_name' => ['required', 'string', 'max:255'],
            'service_type' => ['required', 'in:'.implode(',', array_keys(Service::TYPES))],
            'problem_description' => ['required', 'string', 'max:2000'],
            'owned_components' => ['nullable', 'string', 'max:2000'],
        ]);

        $customer = null;

        if (Auth::check()) {
            $customer = Customer::query()->firstOrNew(['user_id' => Auth::id()]);
            $customer->name = $customer->name ?: $validated['name'];
            $customer->whatsapp = $customer->whatsapp ?: $validated['whatsapp'];
            $customer->save();
        } else {
            $customer = Customer::query()->create([
                'name' => $validated['name'],
                'whatsapp' => $validated['whatsapp'],
            ]);
        }

        $description = $validated['problem_description'];
        if (! empty($validated['owned_components'])) {
            $description .= "\n\nKOMPONEN BAWAAN KLIENT:\n".$validated['owned_components'];
        }

        $service = Service::query()->create([
            'code' => Service::generateCode(),
            'invoice_number' => Service::generateInvoiceNumber(),
            'customer_id' => $customer->id,
            'company_name' => $validated['company_name'] ?? null,
            'device_name' => $validated['device_name'],
            'source' => 'website',
            'service_type' => $validated['service_type'],
            'status' => 'received',
            'problem_description' => $description,
        ]);

        $waLink = WhatsAppService::link("Halo KeeHub, saya request service PC atas nama {$validated['name']} (Kode: {$service->code}).");

        return redirect()->route('service.index', ['q' => $service->code])
            ->with('success', "Permohonan servis berhasil dicatat dengan kode {$service->code}! Tim teknisi KeeHub akan segera mengabari Anda via WhatsApp.")
            ->with('wa_link', $waLink);
    }
}
