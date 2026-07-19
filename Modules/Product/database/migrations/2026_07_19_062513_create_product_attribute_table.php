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
        Schema::create('product_attribute', function (Blueprint $table) {
            $table->foreignId('product_id')->index()
                ->references('id')->on('products')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('attribute_id')->index()
                ->references('id')->on('attributes')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attribute');
    }
};
