<?php

use Modules\Order\Http\Controllers\Api\OrderController;

Route::prefix('orders')->name('orders.')->group(function () {

    Route::apiResource('/', OrderController::class)->parameter('', 'product')->only(['store']);

});
