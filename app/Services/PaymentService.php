<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public static function record($invoice, string $method, int $amount, $paidAt, ?string $reference = null, ?string $notes = null, ?int $userId = null): Payment
    {
        if ($invoice->status === 'void') {
            throw new \DomainException('Invoice berstatus void dan tidak dapat menerima payment.');
        }

        $remaining = $invoice->remainingAmount();

        if ($amount <= 0) {
            throw new \DomainException('Jumlah payment harus lebih dari 0.');
        }

        if ($amount > $remaining) {
            throw new \DomainException("Payment melebihi sisa tagihan. Sisa: Rp{$remaining}.");
        }

        return DB::transaction(function () use ($invoice, $method, $amount, $paidAt, $reference, $notes, $userId) {
            return Payment::query()->create([
                'code' => CodeGenerator::next('PAY'),
                'invoice_id' => $invoice->id,
                'method' => $method,
                'amount' => $amount,
                'paid_at' => $paidAt,
                'reference' => $reference,
                'notes' => $notes,
                'user_id' => $userId,
            ]);
        });
    }
}
