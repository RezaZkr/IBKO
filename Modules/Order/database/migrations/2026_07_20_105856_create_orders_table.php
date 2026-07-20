<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Customer\Models\Customer;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignIdFor(Customer::class)
                ->index()->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('total_amount');
            $table->unsignedTinyInteger('status')->default(\Modules\Order\Enums\OrderStatusEnum::Pending);
            $table->unsignedTinyInteger('payment_status')->default(\Modules\Order\Enums\OrderPaymentStatusEnum::Unpaid);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
