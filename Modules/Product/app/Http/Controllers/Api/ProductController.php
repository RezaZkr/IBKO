<?php

namespace Modules\Product\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Product\Filters\ProductFilters;
use Modules\Product\Http\Requests\Api\FilterProductRequest;
use Modules\Product\Models\Product;
use Modules\Product\Transformers\Api\ProductResource;

class ProductController extends Controller
{
    public function index(FilterProductRequest $request)
    {
        $perPage = (int)$request->input('per_page', 15);

        $products = Product::query()
            ->active()
            ->with([
                'category:id,title,slug',
                'variants' => function ($query) {
                    $query->with(['media', 'attributeValues.attribute']);
                },
            ])
            ->withMin('variants as min_price', 'price')
            ->withMax('variants as max_price', 'price')
            ->filter(new ProductFilters($request))
            ->paginate($perPage)
            ->withQueryString();

        return ProductResource::collection($products);
    }

    public function show($id)
    {
        $product = Product::query()
            ->active()
            ->with([
                'category:id,title,slug',
                'variants' => function ($query) {
                    $query->with(['media', 'attributeValues.attribute']);
                },
            ])->findOrFail($id);

        return ProductResource::make($product);
    }
}
