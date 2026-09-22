<?php

namespace Tests\Feature\Services;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    private function seedInvoice(int $total = 1000000, int $paidAmount = 0, string $status = 'unpaid'): Invoice
    {
        $customer = Customer::factory()->create();

        $order = Order::query()->create([
            'code' => 'ORD-'.now()->format('Ymd').'-'.str_pad((string) fake()->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
            'customer_id' => $customer->id,
            'type' => 'product',
            'channel' => 'website',
            'status' => 'pending',
            'subtotal' => $total,
            'discount' => 0,
            'shipping_cost' => 0,
            'total' => $total,
            'shipping_name' => 'Test Customer',
            'shipping_phone' => '6281234567890',
            'shipping_address' => 'Jl. Test No. 1',
        ]);

        return Invoice::query()->create([
            'code' => 'INV-'.now()->format('Ymd').'-'.str_pad((string) fake()->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'subtotal' => $total,
            'discount' => 0,
            'shipping' => 0,
            'total' => $total,
            'paid_amount' => $paidAmount,
            'status' => $status,
        ]);
    }

    public function test_records_full_payment_and_marks_invoice_paid(): void
    {
        $invoice = $this->seedInvoice(total: 1500000);

        $payment = PaymentService::record($invoice, 'cash', 1500000, now());

        $this->assertStringStartsWith('PAY', $payment->code);
        $this->assertSame('cash', $payment->method);
        $this->assertSame(1500000, $payment->amount);

        $invoice->refresh();
        $this->assertSame('paid', $invoice->status);
        $this->assertSame(1500000, $invoice->paid_amount);
        $this->assertSame(0, $invoice->remainingAmount());
    }

    public function test_records_partial_payment_then_full_payment(): void
    {
        $invoice = $this->seedInvoice(total: 1000000);

        PaymentService::record($invoice, 'transfer', 400000, now());

        $invoice->refresh();
        $this->assertSame('partial', $invoice->status);
        $this->assertSame(600000, $invoice->remainingAmount());

        PaymentService::record($invoice, 'cash', 600000, now());

        $invoice->refresh();
        $this->assertSame('paid', $invoice->status);
        $this->assertSame(0, $invoice->remainingAmount());
    }

    public function test_rejects_void_invoice(): void
    {
        $invoice = $this->seedInvoice(status: 'void');

        $this->expectException(\DomainException::class);

        PaymentService::record($invoice, 'cash', 100000, now());
    }

    public function test_rejects_non_positive_amount(): void
    {
        $invoice = $this->seedInvoice();

        $this->expectException(\DomainException::class);

        PaymentService::record($invoice, 'cash', 0, now());
    }

    public function test_rejects_amount_exceeding_remaining_balance(): void
    {
        $invoice = $this->seedInvoice(total: 1000000);

        $this->expectException(\DomainException::class);

        PaymentService::record($invoice, 'cash', 1200000, now());
    }

    public function test_records_payment_metadata(): void
    {
        $user = User::factory()->create();
        $invoice = $this->seedInvoice(total: 1000000);

        $payment = PaymentService::record(
            invoice: $invoice,
            method: 'qris',
            amount: 300000,
            paidAt: now()->subDay(),
            reference: 'TRX-123',
            notes: 'DP',
            userId: $user->id,
        );

        $this->assertSame('TRX-123', $payment->reference);
        $this->assertSame('DP', $payment->notes);
        $this->assertSame($user->id, $payment->user_id);
        $this->assertSame($invoice->id, $payment->invoice_id);

        $invoice->refresh();
        $this->assertSame('partial', $invoice->status);
    }
}
