<?php

namespace Modules\Payment\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\General\Enums\GuardEnum;
use Modules\Order\Models\Order;
use Modules\Payment\Exceptions\OrderNotPayableException;
use Modules\Payment\Models\Payment;
use Modules\Payment\Services\PaymentService;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PaymentController extends Controller
{
    public function __construct(private readonly PaymentService $paymentService)
    {
    }

    public function initiate($number)
    {
        $order = Order::query()
            ->where('order_number', $number)
            ->where('customer_id', auth()->guard(GuardEnum::CUSTOMER)->id())
            ->firstOrFail();
        try {
            $payment = $this->paymentService->initiate($order);
        } catch (OrderNotPayableException $e) {
            return response()->error(message: $e->getMessage(), status: ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->success(data: [
            'payment_url' => fake()->url() . $payment->token,
            'token'       => $payment->token,
            'amount'      => $payment->amount,
        ]);
    }

    public function callback(Request $request, string $token)
    {
        $payment = Payment::query()->where('token', '=', $token)->firstOrFail();

        $success = $request->input('result') === 'success';

        $payment = $this->paymentService->process($payment, $success);

        $frontendUrl = config('app.frontend_url', '/');
        $status = $payment->status->value;

        logger([
            'status' => $payment->status->label(),
            'value'  => $status,
        ]);

        return redirect()->away("{$frontendUrl}/orders/{$payment->order->order_number}/result?payment_status={$status}");
    }


}
