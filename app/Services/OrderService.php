<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public static function statusFlow(): array
    {
        return [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['processing', 'cancelled'],
            'processing' => ['ready', 'cancelled'],
            'ready' => ['shipped', 'completed', 'cancelled'],
            'shipped' => ['completed', 'cancelled'],
            'completed' => [],
            'cancelled' => [],
        ];
    }

    public static function canTransition(string $from, string $to): bool
    {
        return in_array($to, self::statusFlow()[$from] ?? [], true);
    }

    public static function setStatus(Order $order, string $newStatus, ?string $notes = null, ?User $user = null): Order
    {
        if (! in_array($newStatus, Order::STATUSES, true)) {
            throw new \InvalidArgumentException("Invalid status: {$newStatus}");
        }

        if (! self::canTransition($order->status, $newStatus)) {
            throw new \DomainException("Transisi status tidak valid: {$order->status} → {$newStatus}.");
        }

        return DB::transaction(function () use ($order, $newStatus, $notes, $user) {
            $from = $order->status;
            $order->status = $newStatus;
            $order->save();

            OrderStatusHistory::query()->create([
                'order_id' => $order->id,
                'from_status' => $from,
                'to_status' => $newStatus,
                'notes' => $notes,
                'user_id' => $user?->id,
            ]);

            if (in_array($newStatus, ['confirmed', 'processing'], true)) {
                self::deductStock($order, $user);
            }

            if ($newStatus === 'cancelled') {
                InventoryService::reverseMovementsFor(Order::class, $order->id, $user?->id, "Reversal: order {$order->code} cancelled");
            }

            return $order;
        });
    }

    private static function deductStock(Order $order, ?User $user): void
    {
        $alreadyOut = StockMovement::query()
            ->where('reference_type', Order::class)
            ->where('reference_id', $order->id)
            ->where('type', 'out')
            ->exists();

        if ($alreadyOut) {
            return;
        }

        $order->load('items.product');

        foreach ($order->items as $item) {
            if ($item->item_type === 'customer_owned' || ! $item->affects_stock || ! $item->product) {
                continue;
            }

            InventoryService::move(
                $item->product,
                'out',
                $item->quantity,
                Order::class,
                $order->id,
                "Order {$order->code}",
                $user?->id
            );
        }
    }

    public static function createManual(array $data, array $items, ?User $user = null): Order
    {
        return DB::transaction(function () use ($data, $items, $user) {
            $subtotal = 0;
            $mappedItems = [];

            foreach ($items as $item) {
                $product = $item['product_id'] ?? null ? Product::query()->findOrFail($item['product_id']) : null;
                $price = $item['price'] ?? $product?->price ?? 0;
                $quantity = max(1, (int) ($item['quantity'] ?? 1));
                $lineTotal = $price * $quantity;
                $subtotal += $lineTotal;

                $mappedItems[] = [
                    'item_type' => $item['item_type'] ?? 'product',
                    'product_id' => $product?->id,
                    'name' => $item['name'] ?? $product?->name ?? 'Item',
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $lineTotal,
                    'affects_stock' => ($item['item_type'] ?? 'product') !== 'customer_owned',
                ];
            }

            $discount = (int) ($data['discount'] ?? 0);
            $shipping = (int) ($data['shipping_cost'] ?? 0);

            $order = Order::query()->create([
                'code' => Order::generateCode(),
                'customer_id' => $data['customer_id'] ?? null,
                'user_id' => $user?->id,
                'type' => $data['type'] ?? 'product',
                'channel' => $data['channel'] ?? 'admin',
                'status' => 'pending',
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_cost' => $shipping,
                'total' => $subtotal - $discount + $shipping,
                'notes' => $data['notes'] ?? null,
                'shipping_name' => $data['shipping_name'] ?? null,
                'shipping_phone' => $data['shipping_phone'] ?? null,
                'shipping_address' => $data['shipping_address'] ?? null,
            ]);

            foreach ($mappedItems as $mapped) {
                $order->items()->create($mapped);
            }

            self::createInvoice($order);

            return $order;
        });
    }

    public static function createInvoice(Order $order): Invoice
    {
        $existing = $order->invoice()->first();

        if ($existing) {
            return $existing;
        }

        $invoice = Invoice::query()->create([
            'code' => Invoice::generateCode(),
            'order_id' => $order->id,
            'customer_id' => $order->customer_id,
            'subtotal' => $order->subtotal,
            'discount' => $order->discount,
            'shipping' => $order->shipping_cost,
            'total' => $order->total,
            'status' => 'unpaid',
        ]);

        $order->setRelation('invoice', $invoice);

        foreach ($order->items as $item) {
            $invoice->items()->create([
                'name' => $item->name,
                'description' => $item->description,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->total,
            ]);
        }

        return $invoice;
    }
}
