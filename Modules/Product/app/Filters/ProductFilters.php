<?php

namespace Modules\Product\Filters;

use Modules\Attribute\Models\Attribute;

class ProductFilters extends QueryFilters
{
    protected function category($value): void
    {
        $this->builder->whereHas('category', function ($q) use ($value) {
            $q->where('slug', $value);
        });
    }

    protected function minPrice($value): void
    {
        $this->builder->whereHas('variants', fn($q) => $q->where('price', '>=', $value));
    }

    protected function maxPrice($value): void
    {
        $this->builder->whereHas('variants', fn($q) => $q->where('price', '<=', $value));
    }

    protected function inStock($value): void
    {
        if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
            $this->builder->whereHas('variants', fn($q) => $q->where('quantity', '>', 0));
        }
    }

    protected function sort($value): void
    {
        match ($value) {
            'price_asc' => $this->builder->orderBy('min_price', 'asc'),
            'price_desc' => $this->builder->orderBy('min_price', 'desc'),
            'newest' => $this->builder->orderBy('created_at', 'desc'),
            'oldest' => $this->builder->orderBy('created_at', 'asc'),
            default => null,
        };
    }

    protected function applyDynamicAttributes(): void
    {
        $filters = $this->dynamicAttributeFilters();

        if (empty($filters)) {
            return;
        }

        $validAttributes = Attribute::pluck('name')->flip();

        $this->builder->whereHas('variants', function ($variantQuery) use ($filters, $validAttributes) {
            foreach ($filters as $attributeName => $value) {
                if (!isset($validAttributes[$attributeName])) {
                    continue;
                }


                $variantQuery->whereHas('attributeValues', function ($q) use ($attributeName, $value) {
                    $q->where('name', $value)
                        ->whereHas('attribute', fn($aq) => $aq->where('name', $attributeName));
                });
            }
        });
    }
}
