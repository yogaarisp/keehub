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
    public function create(): View
    {
        return view('shop.service-request', [
            'serviceTypes' => Service::TYPES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'whatsapp' => ['required', 'string', 'max:25'],
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
            $description .= "\n\nCUSTOMER OWNED COMPONENTS:\n".$validated['owned_components'];
        }

        Service::query()->create([
            'code' => Service::generateCode(),
            'customer_id' => $customer->id,
            'source' => 'website',
            'service_type' => $validated['service_type'],
            'status' => 'received',
            'problem_description' => $description,
        ]);

        $waLink = WhatsAppService::link("Halo KeeHub, saya request service atas nama {$validated['name']}.");

        return redirect()->route('service.create')->with('success', 'Request service diterima! Tim kami akan menghubungi kamu via WhatsApp.')
            ->with('wa_link', $waLink);
    }
}
