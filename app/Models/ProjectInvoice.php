<?php

namespace App\Models;

use App\Services\CodeGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectInvoice extends Model
{
    use HasFactory;

    public const PROJECT_TYPES = [
        'website' => 'Website Company Profile / Landing Page',
        'web_app' => 'Web Application (SaaS / Portal / Dashboard)',
        'mobile_app' => 'Aplikasi Mobile (Android / iOS)',
        'system' => 'Sistem Informasi (ERP / CRM / POS Kasir)',
        'ecommerce' => 'Website Toko Online / E-Commerce',
        'maintenance' => 'Maintenance, Cloud Server & SLA Support',
        'consulting' => 'Konsultasi IT & UI/UX Design',
        'other' => 'Lainnya / Custom Project',
    ];

    public const PAYMENT_TERMS = [
        'full' => 'Full Payment (100%)',
        'dp' => 'Pembayaran DP / Uang Muka',
        'termin_2' => 'Termin 2 / UAT (Testing)',
        'pelunasan' => 'Pelunasan / Final Handover',
        'monthly' => 'Tagihan Bulanan (Retainer / Subscription)',
        'custom' => 'Kustom / Kesepakatan Khusus',
    ];

    public const STATUSES = [
        'draft' => 'Draft',
        'unpaid' => 'Belum Lunas',
        'partial' => 'Sebagian (DP Masuk)',
        'paid' => 'Lunas',
        'cancelled' => 'Dibatalkan',
    ];

    protected $fillable = [
        'code',
        'customer_id',
        'project_name',
        'project_type',
        'client_name',
        'client_company',
        'client_email',
        'client_phone',
        'client_address',
        'invoice_date',
        'due_date',
        'payment_term',
        'payment_term_label',
        'subtotal',
        'discount',
        'tax',
        'total',
        'paid_amount',
        'status',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
        'signer_name',
        'notes',
        'terms',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'invoice_date' => 'date',
            'due_date' => 'date',
            'subtotal' => 'integer',
            'discount' => 'integer',
            'tax' => 'integer',
            'total' => 'integer',
            'paid_amount' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ProjectInvoice $invoice) {
            if (empty($invoice->code)) {
                $invoice->code = static::generateCode();
            }
        });
    }

    public static function generateCode(): string
    {
        return CodeGenerator::next('INV-KTC');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProjectInvoiceItem::class)->orderBy('sort_order');
    }

    public function remainingAmount(): int
    {
        return max(0, $this->total - $this->paid_amount);
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid' || ($this->total > 0 && $this->paid_amount >= $this->total);
    }

    public function projectTypeLabel(): string
    {
        return self::PROJECT_TYPES[$this->project_type] ?? ucfirst($this->project_type);
    }

    public function paymentTermLabel(): string
    {
        if ($this->payment_term_label) {
            return $this->payment_term_label;
        }

        return self::PAYMENT_TERMS[$this->payment_term] ?? ucfirst($this->payment_term);
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'paid' => 'success',
            'partial' => 'warning',
            'unpaid' => 'danger',
            'draft' => 'gray',
            'cancelled' => 'danger',
            default => 'info',
        };
    }
}
