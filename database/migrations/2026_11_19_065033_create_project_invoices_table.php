<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('project_name');
            $table->string('project_type')->default('website'); // website, web_app, mobile_app, system, maintenance, other
            $table->string('client_name');
            $table->string('client_company')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_phone')->nullable();
            $table->text('client_address')->nullable();
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->string('payment_term')->default('full'); // full, dp, termin_2, pelunasan, custom
            $table->string('payment_term_label')->nullable();
            $table->unsignedBigInteger('subtotal')->default(0);
            $table->unsignedBigInteger('discount')->default(0);
            $table->unsignedBigInteger('tax')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->unsignedBigInteger('paid_amount')->default(0);
            $table->string('status')->default('unpaid'); // draft, unpaid, partial, paid, cancelled
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_holder')->nullable();
            $table->string('signer_name')->default('Keetech Finance & Billing');
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();
            $table->timestamps();
        });

        Schema::create('project_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_invoice_id')->constrained()->cascadeOnDelete();
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('unit')->default('Paket');
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_invoice_items');
        Schema::dropIfExists('project_invoices');
    }
};
