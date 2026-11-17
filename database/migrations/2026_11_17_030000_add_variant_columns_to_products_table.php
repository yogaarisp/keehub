<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('variant_group', 100)->nullable()->index()->after('category_id');
            $table->string('variant_label', 50)->nullable()->after('variant_group');
            $table->string('variant_type', 50)->nullable()->default('Kapasitas')->after('variant_label');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['variant_group']);
            $table->dropColumn(['variant_group', 'variant_label', 'variant_type']);
        });
    }
};
