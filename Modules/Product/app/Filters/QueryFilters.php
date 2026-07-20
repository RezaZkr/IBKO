<?php

namespace Modules\Product\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class QueryFilters
{
    public function __construct(protected Request $request)
    {
    }

    protected Builder $builder;

    protected array $reserved = [
        'category', 'min_price', 'max_price', 'in_stock',
        'sort', 'page', 'per_page',
    ];

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->fixedFilters() as $key => $value) {
            $method = Str::camel($key);
            if ($this->filled($value) && method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        $this->applyDynamicAttributes();

        return $this->builder;
    }

    protected function fixedFilters(): array
    {
        return array_intersect_key(
            $this->request->all(),
            array_flip($this->reserved)
        );
    }

    protected function dynamicAttributeFilters(): array
    {
        return array_diff_key($this->request->all(), array_flip($this->reserved));
    }

    protected function filled($value): bool
    {
        return $value !== null && $value !== '';
    }

    abstract protected function applyDynamicAttributes(): void;
}
