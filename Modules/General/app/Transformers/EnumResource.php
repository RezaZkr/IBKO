<?php

namespace Modules\General\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnumResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $normalized = $this->normalize();

        $data = [
            'value' => $normalized['value'],
            'label' => $normalized['label'],
        ];

        if (array_key_exists('color', $normalized)) {
            $data['color'] = $normalized['color'];
        }

        return $data;
    }

    private function normalize()
    {
        if (is_array($this->resource)) {
            return $this->resource;
        }

        $data = [
            'value' => $this->resource->value,
            'label' => $this->resource->label(),
        ];

        if (method_exists($this->resource, 'color')) {
            $data['color'] = $this->resource->color();
        }

        return $data;
    }

}
