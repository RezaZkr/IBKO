<?php


use Modules\Product\Http\Controllers\Api\ProductController;

Route::prefix('products')->name('products.')->group(function () {

    Route::apiResource('/', ProductController::class)->parameter('', 'product')->only(['index', 'show']);

});
