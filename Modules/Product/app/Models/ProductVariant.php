<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable(['product_id', 'sku', 'price', 'quantity', 'status'])]
class ProductVariant extends Model implements HasMedia
{
    use SoftDeletes,InteractsWithMedia;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
