<?php

namespace Modules\Product\Transformers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\General\Transformers\Api\MediaResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'sku'        => $this->sku,
            'price'      => $this->price,
            'quantity'   => $this->quantity,
            'attributes' => ProductVariantAttributeValueResource::collection($this->whenLoaded('attributeValues')),
            'media'      => MediaResource::collection($this->whenLoaded('media')),
            'product'    => ProductResource::make($this->whenLoaded('product')),
        ];
    }
}
