<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(): Response|RedirectResponse
    {
        if (CartService::itemsWithDetails()->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $customer = null;

        if (Auth::check()) {
            $customer = Customer::query()->where('user_id', Auth::id())->first();
        }

        return response()->view('shop.checkout', [
            'items' => CartService::itemsWithDetails(),
            'subtotal' => CartService::subtotal(),
            'shipShippingCost' => CartService::shippingCost('ship'),
            'customer' => $customer,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'whatsapp' => ['required', 'string', 'max:25'],
            'address' => ['required_if:shipping_method,ship', 'nullable', 'string'],
            'shipping_method' => ['required', 'in:ship,pickup'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $shippingCost = CartService::shippingCost($validated['shipping_method']);

        try {
            $order = CartService::checkout([
                'shipping_name' => $validated['name'],
                'shipping_phone' => $validated['whatsapp'],
                'shipping_address' => $validated['shipping_method'] === 'pickup' ? 'Pickup at Store' : $validated['address'],
                'shipping_cost' => $shippingCost,
                'notes' => $validated['notes'] ?? null,
                'customer_id' => $this->resolveCustomerId($validated),
            ], Auth::user());
        } catch (\DomainException $e) {
            return back()->withErrors(['checkout' => $e->getMessage()]);
        }

        return redirect()->route('account.orders.show', $order)->with('success', 'Order '.$order->code.' berhasil dibuat!');
    }

    private function resolveCustomerId(array $data): ?int
    {
        $user = Auth::user();

        if ($user) {
            $customer = Customer::query()->firstOrNew(['user_id' => $user->id]);
            $customer->name = $customer->name ?: $data['name'];
            $customer->whatsapp = $customer->whatsapp ?: $data['whatsapp'];
            $customer->save();

            return $customer->id;
        }

        $customer = Customer::query()->create([
            'name' => $data['name'],
            'whatsapp' => $data['whatsapp'],
        ]);

        return $customer->id;
    }
}
