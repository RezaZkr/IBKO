<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_variant_attribute_value', function (Blueprint $table) {
            $table->foreignId('product_variant_id')->index()
                ->references('id')->on('product_variants')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('attribute_id')->index()
                ->references('id')->on('attributes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('attribute_value_id')->index()
                ->references('id')->on('attribute_values')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant_attribute_value');
    }
};
