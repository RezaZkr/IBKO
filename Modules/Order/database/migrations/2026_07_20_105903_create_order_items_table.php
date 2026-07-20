<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Order\Models\Order;
use Modules\Product\Models\ProductVariant;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ProductVariant::class)->index()->nullable()->constrained()->nullOnDelete();
            $table->string('product_title');
            $table->string('sku')->nullable();
            $table->unsignedBigInteger('price');
            $table->unsignedInteger('quantity');
            $table->unsignedBigInteger('total_price'); // price * quantity
            $table->json('attributes_snapshot')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
