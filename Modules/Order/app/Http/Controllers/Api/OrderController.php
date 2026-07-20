<?php

namespace Modules\Order\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Customer\Models\Customer;
use Modules\Order\Exceptions\InsufficientStockException;
use Modules\Order\Exceptions\VariantUnavailableException;
use Modules\Order\Http\Requests\Api\OrderStoreRequest;
use Modules\Order\Services\OrderService;
use Modules\Order\Transformers\Api\OrderResource;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orderService)
    {
    }

    public function store(OrderStoreRequest $request)
    {
        $customer = Customer::firstOrFail();
        try {
            $order = $this->orderService->createOrder(
                customer: $customer,
                items: $request->validated('items'),
            );
            return response()->success(data: [
                'order' => OrderResource::make($order->fresh()->load('items')),
            ], status: ResponseAlias::HTTP_CREATED);
        } catch (InsufficientStockException|VariantUnavailableException $e) {
            return response()->error(message: $e->getMessage(), status: ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);

        }
    }
}
