<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Support\Facades\DB;

class QuotationService
{
    public static function convertToOrder(Quotation $quotation, ?int $userId = null): Order
    {
        if ($quotation->status !== 'accepted') {
            throw new \DomainException('Hanya quotation berstatus Accepted yang dapat dikonversi menjadi order.');
        }

        if ($quotation->order_id) {
            throw new \DomainException('Quotation sudah dikonversi menjadi order.');
        }

        return DB::transaction(function () use ($quotation) {
            $quotation->load('items');

            $items = $quotation->items->map(fn (QuotationItem $item) => [
                'item_type' => $item->item_type === 'custom' ? 'service' : $item->item_type,
                'product_id' => $item->product_id,
                'name' => $item->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ])->all();

            $order = OrderService::createManual([
                'customer_id' => $quotation->customer_id,
                'type' => $quotation->pc_build_id ? 'pc_build' : 'product',
                'channel' => 'admin',
                'discount' => $quotation->discount,
                'shipping_cost' => $quotation->shipping,
                'notes' => "Converted from quotation {$quotation->code}",
                'pc_build_id' => $quotation->pc_build_id,
            ], $items, null);

            $order->update(['quotation_id' => $quotation->id]);

            $quotation->update([
                'status' => 'converted',
                'order_id' => $order->id,
            ]);

            return $order;
        });
    }

    public static function markSent(Quotation $quotation): Quotation
    {
        if ($quotation->status !== 'draft') {
            throw new \DomainException('Hanya quotation berstatus Draft yang dapat dikirim.');
        }

        $quotation->update(['status' => 'sent']);

        return $quotation;
    }

    public static function createFromBuildData(int $customerId, array $items, array $data): Quotation
    {
        return DB::transaction(function () use ($customerId, $items, $data) {
            $subtotal = 0;
            $mapped = [];

            foreach ($items as $item) {
                $lineTotal = ($item['price'] ?? 0) * max(1, (int) ($item['quantity'] ?? 1));
                $subtotal += $lineTotal;
                $mapped[] = [
                    'item_type' => $item['item_type'] ?? 'product',
                    'product_id' => $item['product_id'] ?? null,
                    'name' => $item['name'] ?? 'Item',
                    'quantity' => max(1, (int) ($item['quantity'] ?? 1)),
                    'price' => $item['price'] ?? 0,
                    'total' => $lineTotal,
                ];
            }

            $discount = (int) ($data['discount'] ?? 0);
            $shipping = (int) ($data['shipping'] ?? 0);

            $quotation = Quotation::query()->create([
                'code' => Quotation::generateCode(),
                'customer_id' => $customerId,
                'pc_build_id' => $data['pc_build_id'] ?? null,
                'quotation_date' => now()->toDateString(),
                'expired_date' => $data['expired_date'] ?? now()->addDays(14)->toDateString(),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping' => $shipping,
                'total' => $subtotal - $discount + $shipping,
                'status' => 'draft',
                'notes' => $data['notes'] ?? null,
                'terms' => $data['terms'] ?? null,
            ]);

            foreach ($mapped as $item) {
                $quotation->items()->create($item);
            }

            return $quotation;
        });
    }
}
