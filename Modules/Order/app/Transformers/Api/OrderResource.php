<?php

namespace Modules\Order\Transformers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\General\Transformers\EnumResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'order_number'   => $this->order_number,
            'status'         => EnumResource::make($this->status),
            'payment_status' => EnumResource::make($this->payment_status),
            'total_amount'   => $this->total_amount,
            'items'          => OrderItemResource::collection($this->whenLoaded('items')),
            'created_at'     => $this->created_at->toIso8601String(),
        ];
    }
}
