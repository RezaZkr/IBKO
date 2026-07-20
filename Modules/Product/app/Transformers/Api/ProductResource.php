<?php

namespace Modules\Product\Transformers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Transformers\Api\CategoryResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'slug'        => $this->slug,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'min_price'   => $this->min_price,
            'max_price'   => $this->max_price,
            'category'    => CategoryResource::make($this->whenLoaded('category')),
            'variants'    => ProductVariantResource::collection($this->whenLoaded('variants')),
        ];
    }
}
