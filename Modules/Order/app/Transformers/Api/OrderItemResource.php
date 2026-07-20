<?php

namespace Modules\Order\Transformers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\General\Transformers\EnumResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'product_title' => $this->product_title,
            'sku'           => $this->sku,
            'price'         => $this->price,
            'quantity'      => $this->quantity,
            'total_price'   => $this->total_price,
            'attributes'    => $this->attributes_snapshot,
        ];
    }
}
