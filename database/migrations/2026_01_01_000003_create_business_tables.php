<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pc_builds', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('purpose', 50)->nullable();
            $table->unsignedBigInteger('budget')->nullable();
            $table->unsignedBigInteger('total_price')->default(0);
            $table->string('status', 20)->default('draft')->index();
            $table->string('share_token', 64)->unique()->nullable();
            $table->timestamps();
        });

        Schema::create('pc_build_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pc_build_id')->constrained()->cascadeOnDelete();
            $table->string('slot', 30)->index();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('price')->default(0);
            $table->timestamps();
            $table->unique(['pc_build_id', 'slot']);
        });

        Schema::create('compatibility_rules', function (Blueprint $table) {
            $table->id();
            $table->string('rule_key', 60)->unique();
            $table->string('title');
            $table->json('params')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['product', 'pc_build', 'service', 'product_service'])->default('product')->index();
            $table->enum('channel', ['website', 'admin', 'whatsapp', 'offline'])->default('website');
            $table->enum('status', ['pending', 'confirmed', 'processing', 'ready', 'shipped', 'completed', 'cancelled'])->default('pending')->index();
            $table->unsignedBigInteger('subtotal')->default(0);
            $table->unsignedBigInteger('discount')->default(0);
            $table->unsignedBigInteger('shipping_cost')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('pc_build_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('quotation_id')->nullable();
            $table->foreignId('service_id')->nullable();
            $table->string('shipping_name')->nullable();
            $table->string('shipping_phone', 25)->nullable();
            $table->text('shipping_address')->nullable();
            $table->timestamps();
            $table->index(['customer_id', 'status']);
            $table->index(['status', 'created_at']);
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->enum('item_type', ['product', 'build', 'service', 'labor', 'customer_owned'])->default('product')->index();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->boolean('affects_stock')->default(true);
            $table->timestamps();
            $table->index('order_id');
        });

        Schema::create('order_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('from_status', 20)->nullable();
            $table->string('to_status', 20);
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->index('order_id');
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('subtotal')->default(0);
            $table->unsignedBigInteger('discount')->default(0);
            $table->unsignedBigInteger('shipping')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->unsignedBigInteger('paid_amount')->default(0);
            $table->enum('status', ['unpaid', 'partial', 'paid', 'refunded', 'void'])->default('unpaid')->index();
            $table->date('due_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['order_id', 'status']);
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->enum('method', ['cash', 'transfer', 'qris', 'ewallet', 'debit', 'credit', 'other'])->default('transfer');
            $table->unsignedBigInteger('amount')->default(0);
            $table->date('paid_at');
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->index('invoice_id');
        });

        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('courier', 50)->nullable();
            $table->string('tracking_number')->nullable()->index();
            $table->unsignedBigInteger('shipping_cost')->default(0);
            $table->date('shipped_at')->nullable();
            $table->enum('status', ['preparing', 'shipped', 'in_transit', 'delivered', 'pickup'])->default('preparing')->index();
            $table->boolean('is_pickup')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('pc_build_id')->nullable()->constrained()->nullOnDelete();
            $table->date('quotation_date');
            $table->date('expired_date')->nullable();
            $table->unsignedBigInteger('subtotal')->default(0);
            $table->unsignedBigInteger('discount')->default(0);
            $table->unsignedBigInteger('shipping')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->enum('status', ['draft', 'sent', 'accepted', 'rejected', 'expired', 'converted'])->default('draft')->index();
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->cascadeOnDelete();
            $table->enum('item_type', ['product', 'service', 'labor', 'custom'])->default('product');
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('source', ['website', 'walk_in', 'whatsapp', 'admin'])->default('website');
            $table->string('service_type', 50)->index();
            $table->enum('status', ['received', 'checking', 'waiting_approval', 'processing', 'testing', 'ready', 'completed', 'cancelled'])->default('received')->index();
            $table->text('problem_description')->nullable();
            $table->text('diagnosis')->nullable();
            $table->unsignedBigInteger('estimated_cost')->default(0);
            $table->unsignedBigInteger('total_cost')->default(0);
            $table->foreignId('technician_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['customer_id', 'status']);
        });

        Schema::create('service_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->enum('item_type', ['product', 'labor', 'customer_owned'])->default('labor')->index();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->timestamps();
        });

        Schema::create('service_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('from_status', 30)->nullable();
            $table->string('to_status', 30);
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('qc_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('technician_id')->nullable()->constrained('users')->nullOnDelete();
            $table->json('checklist')->nullable();
            $table->text('notes')->nullable();
            $table->enum('result', ['pass', 'fail', 'pending'])->default('pending')->index();
            $table->timestamp('checked_at')->nullable();
            $table->timestamps();
        });

        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('pc_build_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->enum('item_type', ['product', 'build', 'service'])->default('product');
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('pc_build_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('qc_records');
        Schema::dropIfExists('service_status_history');
        Schema::dropIfExists('service_items');
        Schema::dropIfExists('services');
        Schema::dropIfExists('quotation_items');
        Schema::dropIfExists('quotations');
        Schema::dropIfExists('shipments');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('order_status_history');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('compatibility_rules');
        Schema::dropIfExists('pc_build_items');
        Schema::dropIfExists('pc_builds');
    }
};
