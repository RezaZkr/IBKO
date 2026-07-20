<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Attribute\Models\Attribute;
use Modules\Category\Models\Category;
use Modules\General\Enums\BooleanEnum;
use Modules\Product\Filters\QueryFilters;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Builder;


#[Fillable(['title', 'slug', 'category_id', 'description', 'status'])]
class Product extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected function casts(): array
    {
        return [
            'status' => BooleanEnum::class,
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute', 'product_id', 'attribute_id');
    }

    #[Scope]
    protected function filter(Builder $query, QueryFilters $filters): Builder
    {
        return $filters->apply($query);
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', '=', BooleanEnum::ACTIVE);
    }
}
