<?php

namespace Modules\Attribute\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Attribute\Enums\AttributeSelectTypeEnum;
use Modules\General\Enums\BooleanEnum;
use Modules\Product\Models\Product;

#[Fillable(['name', 'select_type', 'filterable'])]
class Attribute extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'select_type' => AttributeSelectTypeEnum::class,
            'filterable'  => BooleanEnum::class,
        ];
    }

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_attribute', 'attribute_id', 'product_id');
    }
}
