<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PcBuild;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();

        $orders = Order::query()->whereHas('customer', fn ($q) => $q->where('user_id', $user->id))->with('invoice')->latest()->take(5)->get();

        $totalOrders = Order::query()->whereHas('customer', fn ($q) => $q->where('user_id', $user->id))->count();

        $builds = $user->id ? PcBuild::query()->where('user_id', $user->id)->latest()->take(4)->get() : collect();

        return view('account.dashboard', [
            'user' => $user,
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'builds' => $builds,
        ]);
    }

    public function orders(): View
    {
        $orders = Order::query()
            ->whereHas('customer', fn ($q) => $q->where('user_id', Auth::id()))
            ->with('invoice')
            ->latest()
            ->paginate(10);

        return view('account.orders', ['orders' => $orders]);
    }

    public function showOrder(Order $order): View
    {
        abort_unless($order->customer?->user_id === Auth::id(), 403);

        $order->load(['items', 'invoice.payments', 'shipment', 'statusHistory']);

        return view('account.order-detail', ['order' => $order]);
    }

    public function builds(): View
    {
        $builds = PcBuild::query()->where('user_id', Auth::id())->with('items.product')->latest()->paginate(10);

        return view('account.builds', ['builds' => $builds]);
    }
}
