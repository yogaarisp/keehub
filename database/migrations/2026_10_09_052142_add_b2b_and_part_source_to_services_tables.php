<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('invoice_number', 50)->nullable()->unique()->after('code');
            $table->string('company_name')->nullable()->after('customer_id');
            $table->string('device_name')->nullable()->after('service_type');
            $table->string('serial_number')->nullable()->after('device_name');
            $table->string('device_specs')->nullable()->after('serial_number');
            $table->string('completeness')->nullable()->after('device_specs');
            $table->date('due_date')->nullable()->after('status');
            $table->timestamp('completed_at')->nullable()->after('due_date');
        });

        Schema::table('service_items', function (Blueprint $table) {
            $table->enum('part_source', ['keehub', 'vendor'])->default('keehub')->index()->after('item_type');
            $table->string('warranty_info')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('service_items', function (Blueprint $table) {
            $table->dropColumn(['part_source', 'warranty_info']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_number',
                'company_name',
                'device_name',
                'serial_number',
                'device_specs',
                'completeness',
                'due_date',
                'completed_at',
            ]);
        });
    }
};
