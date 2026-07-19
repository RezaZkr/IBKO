<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\General\Enums\BooleanEnum;
use Modules\Product\Models\Product;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->index()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('sku', 10)->unique()->index();
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedTinyInteger('status')->default(BooleanEnum::INACTIVE);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
