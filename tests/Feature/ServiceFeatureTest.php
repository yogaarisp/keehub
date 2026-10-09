<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function createServiceWithItems(): Service
    {
        $customer = Customer::query()->create([
            'name' => 'Budi Santoso',
            'whatsapp' => '081234567890',
        ]);

        $service = Service::query()->create([
            'code' => 'SVC-TEST-001',
            'invoice_number' => 'INV-SVC-TEST-001',
            'customer_id' => $customer->id,
            'company_name' => 'PT Solusi Pratama',
            'device_name' => 'PC Render Threadripper',
            'service_type' => 'troubleshooting',
            'status' => 'processing',
            'problem_description' => 'Mati total saat render',
            'diagnosis' => 'PSU rusak, diganti baru',
        ]);

        // 1. Part Dari KeeHub (Rp 2.000.000)
        ServiceItem::query()->create([
            'service_id' => $service->id,
            'item_type' => 'product',
            'part_source' => 'keehub',
            'name' => 'PSU Corsair 850W Gold',
            'quantity' => 1,
            'price' => 2000000,
            'total' => 2000000,
            'warranty_info' => '5 Tahun',
        ]);

        // 2. Part Dari Vendor (Rp 3.500.000 riil, tetapi Rp 0 di Invoice)
        ServiceItem::query()->create([
            'service_id' => $service->id,
            'item_type' => 'product',
            'part_source' => 'vendor',
            'name' => 'Motherboard Replacement (Garansi Vendor)',
            'quantity' => 1,
            'price' => 3500000,
            'total' => 3500000,
            'warranty_info' => 'Garansi Vendor',
        ]);

        // 3. Jasa / Labor (Rp 250.000)
        ServiceItem::query()->create([
            'service_id' => $service->id,
            'item_type' => 'labor',
            'part_source' => 'keehub',
            'name' => 'Jasa Bongkar Pasang & Stress Test',
            'quantity' => 1,
            'price' => 2500000 / 10, // 250.000
            'total' => 250000,
        ]);

        $service->syncTotalCost();

        return $service;
    }

    public function test_service_tracker_page_loads_successfully(): void
    {
        $response = $this->get(route('service.index'));
        $response->assertStatus(200);
        $response->assertSee('Service Tracker');
    }

    public function test_service_tracker_finds_by_code(): void
    {
        $service = $this->createServiceWithItems();

        $response = $this->get(route('service.index', ['q' => $service->code]));
        $response->assertStatus(200);
        $response->assertSee($service->code);
        $response->assertSee('PC Render Threadripper');
        $response->assertSee('PT Solusi Pratama');
        $response->assertSee('SEDANG DIKERJAKAN');
    }

    public function test_service_tracker_finds_by_phone(): void
    {
        $service = $this->createServiceWithItems();

        $response = $this->get(route('service.index', ['q' => '081234567890']));
        $response->assertStatus(200);
        $response->assertSee($service->code);
        $response->assertSee('Budi Santoso');
    }

    public function test_part_source_calculation_logic(): void
    {
        $service = $this->createServiceWithItems();

        // Work Order total must calculate ALL items (2.000.000 + 3.500.000 + 250.000 = 5.750.000)
        $this->assertEquals(5750000, $service->workOrderTotal());

        // Invoice total must ONLY calculate KeeHub parts + Labor (2.000.000 + 250.000 = 2.250.000)
        $this->assertEquals(2250000, $service->invoiceTotal());

        // Vendor parts total
        $this->assertEquals(3500000, $service->vendorPartsTotal());
    }

    public function test_admin_can_download_work_order_and_invoice_pdf(): void
    {
        $service = $this->createServiceWithItems();
        $admin = User::factory()->create(['role' => 'owner']);

        $woResponse = $this->actingAs($admin)->get(route('admin.service.work-order.pdf', $service));
        $woResponse->assertStatus(200);
        $woResponse->assertHeader('content-type', 'application/pdf');

        $invResponse = $this->actingAs($admin)->get(route('admin.service.invoice.pdf', $service));
        $invResponse->assertStatus(200);
        $invResponse->assertHeader('content-type', 'application/pdf');
    }

    public function test_guest_cannot_access_admin_service_pdf(): void
    {
        $service = $this->createServiceWithItems();

        $this->get(route('admin.service.work-order.pdf', $service))
            ->assertRedirect(route('login'));

        $this->get(route('admin.service.invoice.pdf', $service))
            ->assertRedirect(route('login'));
    }
}
