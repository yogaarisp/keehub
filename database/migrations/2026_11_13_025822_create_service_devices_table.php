<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('device_name');
            $table->string('service_type', 50)->nullable();
            $table->string('serial_number')->nullable();
            $table->string('device_specs')->nullable();
            $table->string('completeness')->nullable();
            $table->text('problem_description')->nullable();
            $table->text('diagnosis')->nullable();
            $table->string('status', 30)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['service_id', 'sort_order']);
        });

        Schema::table('service_items', function (Blueprint $table) {
            $table->foreignId('service_device_id')->nullable()->after('service_id')->constrained('service_devices')->nullOnDelete();
        });

        // Migrate existing service data to service_devices
        if (Schema::hasTable('services')) {
            $existingServices = DB::table('services')->get();
            foreach ($existingServices as $svc) {
                if ($svc->device_name || $svc->problem_description || $svc->serial_number) {
                    $deviceId = DB::table('service_devices')->insertGetId([
                        'service_id' => $svc->id,
                        'device_name' => $svc->device_name ?: 'Unit PC',
                        'service_type' => $svc->service_type,
                        'serial_number' => $svc->serial_number,
                        'device_specs' => $svc->device_specs,
                        'completeness' => $svc->completeness,
                        'problem_description' => $svc->problem_description,
                        'diagnosis' => $svc->diagnosis,
                        'notes' => null,
                        'sort_order' => 0,
                        'created_at' => $svc->created_at ?: now(),
                        'updated_at' => $svc->updated_at ?: now(),
                    ]);

                    DB::table('service_items')
                        ->where('service_id', $svc->id)
                        ->update(['service_device_id' => $deviceId]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('service_device_id');
        });

        Schema::dropIfExists('service_devices');
    }
};
