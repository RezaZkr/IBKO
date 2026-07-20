<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Order\Models\Order;
use Modules\Payment\Enums\PaymentStatusEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->index()->constrained()->cascadeOnDelete();
            $table->string('token')->unique();
            $table->unsignedBigInteger('amount');
            $table->unsignedTinyInteger('status')->default(PaymentStatusEnum::Pending);
            $table->string('ref_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
