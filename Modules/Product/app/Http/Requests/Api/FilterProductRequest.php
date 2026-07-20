<?php

namespace Modules\Product\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category'  => ['sometimes', 'string'],
            'min_price' => ['sometimes', 'numeric', 'min:0'],
            'max_price' => ['sometimes', 'numeric', 'min:0'],
            'in_stock'  => ['sometimes', 'boolean'],
            'sort'      => ['sometimes', Rule::in(['price_asc', 'price_desc', 'newest', 'oldest'])],
            'per_page'  => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }
}
