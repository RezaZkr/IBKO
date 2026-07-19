<?php

namespace Modules\Attribute\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Models\ProductVariant;

#[Fillable(['attribute_id', 'name', 'value'])]
class AttributeValue extends Model
{
    use SoftDeletes;

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function productVariants(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_attribute_value', 'attribute_value_id', 'product_variant_id');
    }
}
