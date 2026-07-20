<?php

namespace Modules\Payment\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Order\Enums\OrderPaymentStatusEnum;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Order\Models\Order;
use Modules\Order\Services\OrderService;
use Modules\Payment\Enums\PaymentStatusEnum;
use Modules\Payment\Exceptions\OrderNotPayableException;
use Modules\Payment\Models\Payment;

readonly class PaymentService
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function initiate(Order $order): Payment
    {
        if ($order->payment_status === OrderPaymentStatusEnum::Paid) {
            throw new OrderNotPayableException('already paid');
        }

        if (in_array($order->status, [OrderStatusEnum::Cancelled, OrderStatusEnum::Shipped])) {
            throw new OrderNotPayableException('canceled or shipped, cant paid');
        }

        $existing = $order->payments()
            ->where('status', '=', PaymentStatusEnum::Pending)
            ->latest()
            ->first();

        if ($existing) {
            return $existing;
        }

        return Payment::create([
            'order_id' => $order->id,
            'amount'   => $order->total_amount,
            'status'   => PaymentStatusEnum::Pending,
        ]);
    }

    public function process(Payment $payment, bool $success): Payment
    {
        return DB::transaction(function () use ($payment, $success) {

            $payment = Payment::query()->lockForUpdate()->find($payment->id);

            if ($payment->status !== PaymentStatusEnum::Pending) {
                return $payment;
            }

            $order = $payment->order()->lockForUpdate()->first();

            if ($success) {
                $payment->update([
                    'status' => PaymentStatusEnum::Success,
                    'ref_id' => strtoupper(Str::random(10)),
                ]);

                $this->orderService->confirmPayment($order);
            } else {
                $payment->update([
                    'status' => PaymentStatusEnum::Failed,
                ]);

                $order->update([
                    'payment_status' => OrderPaymentStatusEnum::Failed,
                ]);
            }

            return $payment;
        });
    }
}
