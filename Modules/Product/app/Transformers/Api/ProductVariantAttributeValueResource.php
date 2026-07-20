<?php

namespace Modules\Product\Transformers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantAttributeValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            $this->mergeWhen(!blank($this->attribute), function () {
                return [
                    'id'   => $this->attribute->id,
                    'name' => $this->attribute->name,
                ];
            }),
            'value' => [
                'id'    => $this->id,
                'name'  => $this->name,
                'value' => $this->value,
            ],
        ];
    }
}
