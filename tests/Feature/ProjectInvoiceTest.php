<?php

namespace Tests\Feature;

use App\Models\ProjectInvoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectInvoiceTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create([
            'role' => 'owner',
        ]);
    }

    private function createProjectInvoice(): ProjectInvoice
    {
        $invoice = ProjectInvoice::create([
            'project_name' => 'Pembuatan Website E-Commerce & POS',
            'project_type' => 'website',
            'client_name' => 'Bpk. Ahmad Fauzi',
            'client_company' => 'PT Surya Kencana Abadi',
            'client_email' => 'ahmad@suryakencana.com',
            'client_phone' => '081234567890',
            'client_address' => 'Jl. Pemuda No. 88, Semarang',
            'invoice_date' => now(),
            'due_date' => now()->addDays(14),
            'payment_term' => 'dp',
            'payment_term_label' => 'DP 50% di awal sebelum development',
            'subtotal' => 10000000,
            'discount' => 1000000,
            'tax' => 0,
            'total' => 9000000,
            'paid_amount' => 4500000,
            'status' => 'partial',
            'bank_name' => 'BCA',
            'bank_account_number' => '8030808861',
            'bank_account_holder' => 'PT Keetech Solusi Indonesia',
            'signer_name' => 'Keetech Finance & Billing',
        ]);

        $invoice->items()->create([
            'item_name' => 'Pengembangan Frontend Next.js & UI/UX',
            'description' => 'Halaman Beranda, Katalog Produk, Keranjang, Checkout',
            'quantity' => 1,
            'unit' => 'Paket',
            'price' => 6000000,
            'total' => 6000000,
            'sort_order' => 1,
        ]);

        $invoice->items()->create([
            'item_name' => 'Backend API, Database & Payment Gateway',
            'description' => 'Integrasi Midtrans dan Notifikasi WhatsApp',
            'quantity' => 1,
            'unit' => 'Paket',
            'price' => 4000000,
            'total' => 4000000,
            'sort_order' => 2,
        ]);

        return $invoice;
    }

    public function test_can_create_project_invoice_with_auto_generated_code(): void
    {
        $invoice = $this->createProjectInvoice();

        $this->assertNotNull($invoice->code);
        $this->assertStringStartsWith('INV-KTC', $invoice->code);
        $this->assertSame('PT Surya Kencana Abadi', $invoice->client_company);
        $this->assertSame(4500000, $invoice->remainingAmount());
        $this->assertFalse($invoice->isPaid());
    }

    public function test_guest_is_redirected_when_accessing_admin_pdf(): void
    {
        $invoice = $this->createProjectInvoice();

        $response = $this->get(route('admin.project-invoice.pdf', $invoice));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_stream_and_download_project_invoice_pdf(): void
    {
        $admin = $this->createAdmin();
        $invoice = $this->createProjectInvoice();

        $responseStream = $this->actingAs($admin)->get(route('admin.project-invoice.pdf', $invoice));
        $responseStream->assertOk();
        $this->assertSame('application/pdf', $responseStream->headers->get('content-type'));

        $responseDownload = $this->actingAs($admin)->get(route('admin.project-invoice.pdf.download', $invoice));
        $responseDownload->assertOk();
        $this->assertSame('application/pdf', $responseDownload->headers->get('content-type'));
    }

    public function test_public_client_can_view_project_invoice_pdf(): void
    {
        $invoice = $this->createProjectInvoice();

        $response = $this->get(route('project-invoice.public.pdf', $invoice));
        $response->assertOk();
        $this->assertSame('application/pdf', $response->headers->get('content-type'));
    }

    public function test_project_invoice_pdf_contains_keetech_branding_and_no_keehub(): void
    {
        $invoice = $this->createProjectInvoice();
        $rendered = view('pdf.keetech-project-invoice', ['invoice' => $invoice])->render();

        $this->assertStringContainsString('KEETECH', $rendered);
        $this->assertStringContainsString('PT KEETECH SOLUSI INDONESIA', $rendered);
        $this->assertStringContainsString('PT Surya Kencana Abadi', $rendered);
        $this->assertStringContainsString('DP 50% di awal sebelum development', $rendered);
        $this->assertStringNotContainsString('KeeHub', $rendered);
        $this->assertStringNotContainsString('keehub', $rendered);
    }
}
