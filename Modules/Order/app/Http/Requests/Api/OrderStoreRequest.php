<?php

namespace Modules\Order\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'items'              => ['required', 'array', 'min:1'],
            'items.*.variant_id' => ['required', 'integer', 'exists:product_variants,id'],
            'items.*.quantity'   => ['required', 'integer', 'min:1', 'max:100'],
        ];
    }
}
